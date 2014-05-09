/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
!function($){
    var Item = function() {
        this.sku_id = 0;
        this.image = {
            zoom: function(elem)
            {
                var href = $(elem).attr("href");
                $("#small-images a").removeClass('active');
                $(elem).addClass('active');
                $("#main-image img").attr("src",href);
                $("#main-image a").attr("href",href);
            }
        };

        this.count = {
            smaller: function()
            {
                var input = $('#num'),
                    val = parseInt(input.val());
                input.val(val-1).change();
            },

            bigger: function()
            {
                var input = $('#num'),
                    val = parseInt(input.val());
                input.val(val+1).change();
            }
        };

        this.addToCart = function() {
            var has_inputs  = ($(".input-property").length > 0),
                iid         = $("#iid").data('value'),
                count       = Math.abs(parseInt($("#num").val())),
                error       = false,
                paramsError = false,
                url         = '/cart/add?iid='+iid+'&count='+count,
                quantity    = parseInt( $("#item-count").text() );

            if(quantity === 0 || isNaN(quantity)) {
                helper.showMessage('Товара нет в наличии','error');
                error = true;
            }
            else if(count > quantity) {
                helper.showMessage('Вы пытаетесь заказать слишком много товаров','error');
                error = true;
            }

            //Проверяем правильность выбора параметров
            if( has_inputs ) {
                $(".input-param").each(function(){
                    if( $(this).val() === '0' ) {
                        paramsError = true;
                    } else {
                        url += '&props[' + $(this).attr("data-fakePid") + ']='+$(this).attr("data-fakeVid");
                    }
                });
            } else {
                Item.sku_id = item_params[ "" ].id;
            }
            if(!error && !paramsError) { //Ошибок нет. Отправляем запрос
                url += '&sku_id=' + Item.sku_id;
                var loader = $('<div class="loader" />').css('float','right');
                $("#add-to-cart").parent().append(loader);
                $.ajax({
                    url: url,
                    success: function(data) {
                        helper.showMessage(data,'success');
                        helper.cartReload();
                    },
                    complete: function(){
                        loader.hide().remove();
                    }
                });
            } else if(paramsError) {
                helper.showMessage('Вы не выбрали параметры товара','error');
            }
        };

        this.reloadSku = function(elem) {
            var pid = $(elem).data('pid'),
                vid  = $(elem).data('vid');

            $("#pid_"+pid).val(vid);

            $(elem).parent().find('a').removeClass('active');
            $(elem).addClass('active');

            if( $(elem).hasClass('image') ) {
                var image = $(elem).attr("href");
                $("#main-image a img").attr('src',image);
                $("#main-image a").attr("href",image);
            }

            var count = Math.abs( parseInt( $("#num").val() ) ),
                val   = '';

            $(".input-param").each(function(){
                if( $(this).val() !== '0' ) {
                    val += $(this).attr("name")+':'+ $(this).val() + ';';
                }
            });

            var param = item_params[ val ];

            var price;
            if( param === undefined ) {
                price = parseFloat( $("#price").text().replace(/(от|р.| )/g,'') );
            } else {
                var qnt             = (param.quantity) ? param.quantity+' шт.' : 'нет',
                    delivery        = helper.getDelivery(count),
                    delivery_per_one= delivery / count;

                price = (param.promo_price) ? param.promo_price : param.price,

                $("#item-count").html(qnt);
                $("#price,#price-per-one").html( helper.getPrice(1,true,price,delivery_per_one) );
                Item.sku_id = param.id;
                $("#item-total").text( helper.getPrice(count,true,price,delivery) );
            }
        };

        this.reloadNum = function() {
            var count = Math.abs( parseInt( $("#num").val() ) );
            if(isNaN(count) || count < 1)
                count = 1;
            $("#num").val(count);
            Item.reloadSku();
        };
    };

    var item = new Item();

    item.image.preload();

    $("#small-images").find('a')
        .hover(function(e){
            item.image.zoom(this);
            e.preventDefault();
        })
        .click(function(e){
            item.image.zoom(this);
            e.preventDefault();
        });

    $(".input-property").click(function(e){
        item.reloadSku(this);
        e.preventDefault();
    });
    $("#num").change(function(){
        item.reloadNum();
    });

    $("#item-smaller").click(function(e){
        item.count.smaller();
        e.preventDefault();
    });
    $("#item-bigger").click(function(e){
        item.count.bigger();
        e.preventDefault();
    });

    $("#add-to-cart").click(function(e){
        item.addToCart();
        e.preventDefault();
    });
}(jQuery);