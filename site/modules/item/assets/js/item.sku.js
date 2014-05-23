yashop.item.sku = (function($){
    return {
        isActive: true,

        $inputProperty: $('.input-property'),

        $itemCount: $("#item-count"),
        $itemPrice: $("#item-price"),
        $itemPricePerOne: $("#item-price-per-one"),
        $itemTotal: $("#item-total"),

        params: null,

        init: function() {
            var me = this;
            this.$inputProperty.click(function(e){
                me.propertyChange(this);
                e.preventDefault();
            });
        },

        propertyChange: function(elem)
        {
            var pid = $(elem).data('pid'),
                vid  = $(elem).data('vid');

            $("#pid_"+pid).val(vid);

            $(elem).parent().find('.active').removeClass('active');
            $(elem).addClass('active');

            if( $(elem).hasClass('image') ) {
                yashop.item.images.zoom(elem);
            }

            this.reload();
        },

        reload: function()
        {
            if(this.params === null)
                return;

            var count = yashop.item.count.getCount(),
                property = [];

            $(".input-param").each(function(){
                if( $(this).val() !== '0' ) {
                    property.push( $(this).attr("name") + ':' + $(this).val() );
                }
            });

            var param = this.params[ property.join(';') ];
            if( param !== undefined ) {
                var price = (param.promo_price) ? param.promo_price : param.price,
                    qnt = param.num;
                var priceOne = yashop.getPrice(1,price),
                    priceTotal = yashop.getPrice(count, price);
                this.$itemPrice.html( priceOne );
                this.$itemPricePerOne.html( priceOne );
                this.$itemTotal.html( priceTotal );
                this.$itemCount.html(qnt);
                yashop.item.skuId = param.id;
            }
        }
    };
})(jQuery);