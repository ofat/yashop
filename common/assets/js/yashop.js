var yashop = (function($){
    return {
        isActive: true,

        defaultCurrency: 'dollar',
        /**
         * @todo: change for database masks
         */
        currencyFormats: {
            dollar: '{number} $'
        },

        currencyRates: {
            dollar: 1
        },

        loader: $('<div class="loader" />'),

        init: function() {},

        cartReload: function() {

        },

        showMessage: function(text,type) {
            console.log(test, type);
            return;
            type = (type === 'error') ? 'danger' : type;
            var block = $('<div id="alert-block" />').addClass('alert alert-'+type).hide().appendTo( $('body') ).html(text);

            $('<button type="button" />').addClass('close').attr('data-dismiss','alert').html('&times;').appendTo( block );

            block.show().delay(1500).fadeOut('normal',function(){
                $(this).remove();
            });
        },

        getPrice: function(num,price,format,currency)
        {
            format = format ? format : true;
            currency = currency ? currency : this.defaultCurrency;
            var currencyRate = this.currencyRates[ currency ],
                price_res = parseFloat(price) * currencyRate * num;

            if(format)
                price_res = this.formatMoney(price_res, currency);

            return price_res;
        },

        formatMoney: function(n, currency, decPlaces, thouSeparator, decSeparator) {
            decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces;
            decSeparator = decSeparator == undefined ? "." : decSeparator;
            thouSeparator = thouSeparator == undefined ? " " : thouSeparator;
            var sign = n < 0 ? "-" : "",
                i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
                j = (j = i.length) > 3 ? j % 3 : 0,
                number = sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");

            return this.currencyFormats[currency].replace('{number}', number);
        }
    };
})(jQuery);

jQuery(document).ready(function () {
    yii.initModule(yashop);
});