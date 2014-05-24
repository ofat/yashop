yashop.cart.row = (function($){
    return {
        isActive: true,

        $cartRemove: $(".cart-remove"),
        $smallerBtn: $('.item-smaller'),
        $biggerBtn: $('.item-bigger'),

        numSelector: '.cart-num',
        rowSelector: '.cart-row',
        priceSelector: '.cart-row-price',
        pricePromoSelector: '.cart-row-promo-price',
        totalSelector: '.cart-row-total',
        totalPromoSelector: '.cart-row-promo-total',

        init: function() {
            var me = this;
            this.$cartRemove.click(function(e){
                me.remove(me.getRow(this));
                e.preventDefault();
            });
            this.$smallerBtn.click(function(e){
                me.smaller(me.getRow(this));
                e.preventDefault();
            });
            this.$biggerBtn.click(function(e){
                me.bigger(me.getRow(this));
                e.preventDefault();
            });
            $(this.numSelector).change(function(){
                me.changeNum(me.getRow(this))
            });
        },

        getRow: function(elem) {
            return $(elem).hasClass('.cart-row') ? $(elem) : $(elem).closest(this.rowSelector);
        },

        remove: function(row) {
            var id  = row.attr('data-id');

            row.hide().remove();

            $.ajax({
                url: yashop.cart.urlRemove,
                data: {
                    id: id
                },
                success: function(){
                    yashop.cart.reCalc();
                    yashop.cartReload();
                }
            });
            yashop.cart.reCalcProgress();
        },

        bigger: function(row)
        {
            var num = this.getNum(row);
            this.setNum(row, num+1).change();
        },

        smaller: function(row)
        {
            var num = this.getNum(row);
            this.setNum(row, num-1).change();
        },
        changeNum: function(row)
        {
            var num = this.getNum(row);

            if(num < 1) num = 1;
            this.setNum(row, num);

            yashop.cart.reCalc();

            $.ajax({
                url: yashop.cart.urlNum,
                data: {
                    id: row.attr('data-id'),
                    num: num
                },
                success: function(){
                    yashop.cartReload();
                }
            });
        },

        getNum: function(row) {
            return Math.abs( parseInt(row.find(this.numSelector).val()) );
        },

        setNum: function(row, num) {
            return row.find(this.numSelector).val(num);
        },

        getPrice: function(row) {
            return parseFloat( row.attr('data-price') );
        },

        getBasePrice: function(row) {
            return parseFloat( row.attr('data-base-price') );
        },

        setPrice: function(row, price, base) {
            row.find(this.priceSelector).html(price);
            if(base)
                row.find(this.pricePromoSelector).html(base).show();
            else
                row.find(this.pricePromoSelector).hide();
        },

        setTotal: function(row, total, base) {
            row.find(this.totalSelector).html(total);
            if(base)
                row.find(this.totalPromoSelector).html(base).show();
            else
                row.find(this.totalPromoSelector).hide();
        }
    }
})(jQuery);