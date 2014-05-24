yashop.cart.check = (function($){
    return {
        isActive: true,

        $cartCheck: $(".cart-check"),
        $cartCheckAll: $(".cart-check-all"),

        init: function() {
            var me = this;
            this.$cartCheck.change(function(){
                me.checkRow(this);
            });
            this.$cartCheckAll.change(function(){
                me.checkAll(this);
            });
        },

        checkRow: function(elem) {
            var check = $(elem).is(':checked'),
                row = yashop.cart.row.getRow(elem);
            if(!check) {
                this.$cartCheckAll.prop('checked',false);
                row.removeClass('active');
            } else {
                row.addClass('active');
                var notActiveRows = $(yashop.cart.row.rowSelector).not('.active');
                if( !notActiveRows.length )
                    this.$cartCheckAll.prop('checked',true);
            }
            yashop.cart.reCalc();
            yashop.cart.checkBtn();
        },

        checkAll: function(elem) {
            var check = $(elem).is(':checked');
            this.$cartCheck.prop('checked',check);
            this.$cartCheckAll.prop('checked', check);
            if(check)
                $(yashop.cart.row.rowSelector).addClass('active');
            else
                $(yashop.cart.row.rowSelector).removeClass('active');

            yashop.cart.reCalc();
            yashop.cart.checkBtn();
        },

        getChecked: function() {
            return $(yashop.cart.row.rowSelector+'.active');
        }
    };
})(jQuery);