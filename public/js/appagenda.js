$(document).ready(function () {

        $.fn.serializeObject = function () {
                var o = {};
                var a = this.serializeArray();
                $.each(a, function () {
                        if (o[this.name]) {
                                if (!o[this.name].push) {
                                        o[this.name] = [o[this.name]];
                                }
                                o[this.name].push(this.value || '');
                        } else {
                                o[this.name] = this.value || '';
                        }
                });
                return o;
        };

        APP = {
                await: false,
                wrapper: null,
                template: null,
                getList: function () {
                        if (!this.await) {
                                this.await = true;
                                var t = this;
                                $.ajax({
                                        url: 'api/contatos/',
                                        type: 'GET',
                                        success: function (response) {
                                                if (t.wrapper == null) {
                                                        t.wrapper = $('#lista');
                                                }
                                                if (t.template == null) {
                                                        t.template = $('.box_repetir:first').detach().removeClass('hidden');
                                                }
                                                t.wrapper.html('');
                                                for (var iterate = 0; iterate < response.length; iterate++) {
                                                        var info = response[iterate];
                                                        var clone = t.template.clone();
                                                        var html = clone.html();
                                                        var keys = Object.keys(info);
                                                        for (var newIterate = 0; newIterate < keys.length; newIterate++) {
                                                                if (keys[newIterate] == "imagem" && info[keys[newIterate]] !== null) {
                                                                        info[keys[newIterate]] = "storage/" + info[keys[newIterate]];
                                                                }
                                                                if (keys[newIterate] == "imagem" && info[keys[newIterate]] == null) {
                                                                        info[keys[newIterate]] = "images/user.png";
                                                                }
                                                                if (info[keys[newIterate]] == null) {
                                                                        info[keys[newIterate]] = "";
                                                                }
                                                                html = html.replaceAll('{' + keys[newIterate] + '}', info[keys[newIterate]]);
                                                        }
                                                        clone.html(html);
                                                        clone.attr('id', info.id);
                                                        clone.appendTo(t.wrapper).bind('click', function () {
                                                                var aside = $('#aside');
                                                                aside.find('h3').text("Editar Contato");
                                                                aside.find('[name=nome]').val($.trim($(this).find('.box_nome').text()));
                                                                aside.find('[name=email]').val($.trim($(this).find('a[href^=mail]').text()));
                                                                aside.find('[name=endereco]').val($.trim($(this).find('span').text()));
                                                                aside.find('[name=telefone]').val($.trim($(this).find('a[href^=tel]').text()));
                                                                aside.find('button').removeClass('btn-success').addClass('btn-primary').text('Editar');
                                                                var form = aside.find('form');
                                                                form.data('id', this.id);
                                                                form.unbind('submit');
                                                                form.bind('submit', function (event) {
                                                                        (!t.update(this));
                                                                        event.preventDefault();
                                                                        return false;
                                                                });
                                                                t.open();
                                                        });
                                                        clone.find('.remove').bind('click', function (event) {
                                                                event.preventDefault();
                                                                event.stopPropagation();
                                                                t.delete($(this).parents(".box_repetir").attr('id'));
                                                        })
                                                }
                                        }
                                });
                                if (this.wrapper == null) {
                                        this.wrapper = t.wrapper;
                                }
                                if (this.template == null) {
                                        this.template = t.template;
                                }
                                this.await = false;
                                delete t;
                        }
                },
                open: function () {
                        $('body').addClass('open');
                },
                close: function () {
                        $('body').removeClass('open');
                },
                save: function (form) {
                        console.log(form);
                        if (form.nome.value == "") {
                                msg("Por favor informe o Nome");
                                this.await = false;
                                return false;
                        }
                        if (form.telefone.value == "") {
                                msg("Por favor informe o Telefone");
                                this.await = false;
                                return false;
                        }
                        this.await = true;
                        $.ajax({
                                url: "api/contatos/store/",
                                type: 'post',
                                data: { contato: $(form).serializeObject(), imagem: (typeof window.image !== "undefined" ? window.image : null) },
                                dataType: "json",
                                succes: function (response) {
                                        APP.await = false;
                                        $(form).reset();
                                        delete window.image;
                                },
                                complete: function () {
                                        APP.getList();
                                }

                        });
                        this.await = false;
                        delete t;
                        return false;
                },
                update: function (form) {
                        if (form.nome.value == "") {
                                msg("Por favor informe o Nome");
                                this.await = false;
                                return false;
                        }
                        if (form.telefone.value == "") {
                                msg("Por favor informe o Telefone");
                                this.await = false;
                                return false;
                        }
                        this.await = true;
                        t = this;
                        $.ajax({
                                url: "api/contatos/update/" + $(form).data('id'),
                                type: 'POST',
                                data: { contato: $(form).serializeObject(), imagem: (typeof window.image !== "undefined" ? window.image : null) },
                                dataType: "json",
                                succes: function (response) {
                                        t.await = false;
                                        $(form).reset();
                                        delete window.image;
                                },
                                complete: function () {
                                        t.getList();
                                }

                        });
                        this.await = false;
                        return false;
                },
                new: function () {
                        var t = this;
                        var aside = $('#aside');
                        delete window.image;
                        aside.find('h3').text("Novo Contato");
                        aside.find('button').addClass('btn-success').text('Cadastrar');
                        var form = aside.find('form');
                        form.data('id', '');
                        form.find('[name]').val('');
                        form.unbind('submit');
                        form.bind('submit', function (event) {
                                t.save(this);
                                event.preventDefault();
                                return false;
                        });
                        t.open();
                },
                delete: function (id) {
                        this.await = true;
                        var t = this;
                        JBox({
                                mensagem: "Tem certeza que deseja excluir este contato?",
                                botoes: {
                                        sim: "Sim", nao: "Não"
                                },
                                acoes: {
                                        sim: function (box) {
                                                JBox.fechar();
                                                $.ajax({
                                                        url: "api/contatos/delete/" + id,
                                                        type: "POST",
                                                        dataType: "json",
                                                        success: function () {
                                                                APP.await = false;
                                                        },
                                                        complete: function () {
                                                                $('#lista>.box_repetir[id=' + id + ']').remove();
                                                        }
                                                });
                                        },
                                        nao: function (box) {
                                                JBox.fechar();
                                        }
                                }
                        })
                },
                getFile: function (event) {
                        var file = event.target.files;
                        file = file[0];
                        var reader = new FileReader();
                        var contents = "";
                        reader.addEventListener('load', function () {
                                window.image = this.result;
                        });
                        reader.readAsDataURL(file);
                        return contents;
                }
        }

        APP.getList();
        $('input#imagem').bind('change', function (event) {
                APP.getFile(event);
        });
        $('#new').bind('click', function () {
                APP.new();
        });
        $('#back').bind('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                APP.close();
        })
});