yashop.item.count = (function($){
    return {
        isActive: true,

        $input: $('#num'),

        $smallerBtn: $('#item-smaller'),
        $biggerBtn: $('#item-bigger'),

        init: function() {
            var me = this;

            this.$input.change(function(){
                me.reloadNum();
            });

            this.$smallerBtn.click(function(e){
                me.smaller();
                e.preventDefault();
            });
            this.$biggerBtn.click(function(e){
                me.bigger();
                e.preventDefault();
            });
        },

        smaller: function()
        {
            var val = this.getCount();
            this.$input.val(val-1).change();
        },

        bigger: function()
        {
            var val = this.getCount();
            this.$input.val(val+1).change();
        },

        reloadNum: function()
        {
            var count = Math.abs( this.getCount() );
            if(isNaN(count) || count < 1)
                count = 1;
            this.$input.val(count);
            yashop.item.sku.reload();
        },

        getCount: function() {
            return parseInt( this.$input.val() );
        }
    };
})(jQuery);