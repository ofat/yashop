yashop.cart = (function($){
    return {
        isActive: true,

        urlRemove: '/cart/default/remove',
        urlNum: '/cart/default/num',

        $totalSum: $('.cart-total'),
        $totalNum: $('.cart-total-num'),
        $submitBtn: $('.cart-submit'),
        $multipleRemove: $('.cart-items-remove'),

        $cartProgress: $("#cart-progress"),
        $cartDataCount: $("#cart-data-count"),
        $cartDataMax: $("#cart-data-max"),

        init: function() {
            var me = this;
            this.$multipleRemove.click(function(e){
                me.removeItems();
                e.preventDefault();
            });
        },

        removeItems: function() {
            var me = this,
                checked = yashop.cart.check.getChecked(),
                ids = [];

            checked.each(function(){
                var row = $(this),
                    id  = row.attr('data-id');

                row.hide().remove();
                ids.push(id);
            });
            $.ajax({
                url: this.urlRemove,
                data: {
                    id: ids
                },
                success: function(){
                    me.reCalc();
                    yashop.cartReload();
                }
            });

            this.reCalcProgress();
        },

        reCalcProgress: function() {
            var count = $(yashop.cart.row.rowSelector).length,
                max = parseInt( this.$cartDataMax.text()),
                progress = count / max * 100;
            this.$cartProgress.css('width', progress+'%');
            this.$cartDataCount.text(count);
        },

        reCalc: function() {
            var sum = 0,
                count = 0,
                row, price, base_price, base_total, total, num, float_price, base_price;
            $(".cart-row.active").each(function(){
                row = yashop.cart.row.getRow(this);
                num = yashop.cart.row.getNum(row);
                float_price = yashop.cart.row.getPrice(row);
                base_price = yashop.cart.row.getBasePrice(row);

                count += num;
                sum += yashop.getPrice(num, float_price, false);

                price = yashop.getPrice(1,float_price);
                base_price = yashop.getPrice(1, base_price);
                total = yashop.getPrice(num, float_price);
                base_total = yashop.getPrice(num, base_price);

                yashop.cart.row.setPrice(row, price, base_price);
                yashop.cart.row.setTotal(row, total, base_total);
            });
            this.setTotals(sum, count);
        },

        setTotals: function(sum, num) {
            this.$totalSum.html( yashop.formatMoney(sum) );
            this.$totalNum.html( num );
        },

        checkBtn: function(){
            var activeRows = $(yashop.cart.row.rowSelector+'.active');
            if( !activeRows.length ) {
                this.$submitBtn.attr('disabled','disabled');
            } else {
                this.$submitBtn.removeAttr('disabled');
            }
        }
    };
})(jQuery);