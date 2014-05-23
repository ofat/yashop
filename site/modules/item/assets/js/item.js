yashop.item = (function($) {
    return {
        isActive: true,

        skuId: 0,
        cartUrl: '/cart/default/add',
        $cartBtn: $("#add-to-cart"),
        $inputHiddenParam: $(".input-param"),
        id: null,
        price: null,

        init: function() {
            var me = this;
            this.$cartBtn.click(function(e){
                me.addToCart();
                e.preventDefault();
            });
        },

        /**
         * @todo: change messages for diff languages
         */
        addToCart: function()
        {
            var hasProperty  = yashop.item.sku.$inputProperty.length > 0,
                count       = yashop.item.count.getCount(),
                error       = false,
                paramsError = false,
                quantity    = parseInt( yashop.item.sku.$itemCount.text()),
                data        = {
                    count: count,
                    props: {}
                };

            if(quantity === 0 || isNaN(quantity)) {
                yashop.showMessage('Товара нет в наличии','error');
                error = true;
            }
            else if(count > quantity) {
                yashop.showMessage('Вы пытаетесь заказать слишком много товаров','error');
                error = true;
            }

            //validate all params
            if( hasProperty ) {
                this.$inputHiddenParam.each(function(){
                    if( $(this).val() === '0' ) {
                        paramsError = true;
                    } else {
                        data.props[ $(this).attr('name') ] = $(this).val();
                    }
                });
            } else {
                this.skuId = yashop.item.sku.params[ "" ].id;
            }

            //if no error then send query to server
            if(!error && !paramsError) {
                data.sku_id = this.skuId;
                var loader = yashop.loader.css('float','right');
                this.$cartBtn.parent().append(loader);
                $.ajax({
                    url: this.cartUrl,
                    data: data,
                    success: function(res) {
                        yashop.showMessage(res,'success');
                        yashop.cartReload();
                    },
                    complete: function(){
                        loader.hide().remove();
                    }
                });
            } else if(paramsError) {
                yashop.showMessage('Вы не выбрали параметры товара','error');
            }
        }
    };
})(jQuery);