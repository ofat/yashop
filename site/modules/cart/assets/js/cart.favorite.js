yashop.cart.favotite = (function($){
    return {
        isActive: true,

        urlFavorite: '/cart/favorite/add',

        $favBtn: $(".cart-favorite"),
        $multipleFavBtn: $(".cart-items-favorite"),

        init: function() {
            var me = this;
            this.$favBtn.click(function(e){
                me.add(this);
                e.preventDefault();
            });
            this.$multipleFavBtn.click(function(e){
                me.addMultiple();
                e.preventDefault();
            });
        },

        add: function(elem) {
            var row = yashop.cart.row.getRow(elem),
                id = row.attr('data-id');
            row.remove();
            this.request(id);
            yashop.cart.reCalcProgress();
        },

        addMultiple: function() {
            var checked = yashop.cart.check.getChecked(),
                ids = [],
                id;
            checked.each(function(){
                id = $(this).attr('data-id');
                $(this).remove();
                ids.push(id);
            });
            this.request(ids);
            yashop.cart.reCalcProgress();
        },

        request: function(id) {
            $.ajax({
                url: this.urlFavorite,
                data: {
                    id: id
                },
                success: function(){}
            });
        }
    }
})(jQuery);