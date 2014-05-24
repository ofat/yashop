yashop.cart.property = (function($){
    return {
        isActive: true,

        urlParams: '/cart/property',
        urlSaveParams: '/cart/property/save',

        params: null,
        $row: null,
        skuId: null,

        $paramEdit: $('.cart-param-edit'),
        editWindow: '.param-editing',
        paramColSelector: '.cart-col-params',
        inputPropertySelector: '.input-property',
        closeSelector: '#cart-props-close',
        saveSelector: '#cart-props-save',

        init: function() {
            var me = this;
            this.$paramEdit.click(function(e){
                me.show(this);
                e.preventDefault();
            });
            $(document).on('click',this.inputPropertySelector,function(e){
                me.propertyChange(this);
                e.preventDefault();
            });
            $(document).on('click',this.closeSelector,function(){
                me.close();
                return false;
            });
            $(document).on('click',this.saveSelector,function(){
                me.save();
                return false;
            });
        },

        show: function(elem) {
            $(this.editWindow).remove();

            this.$row = yashop.cart.row.getRow(elem)
            var id      = this.$row.attr('data-id'),
                container = $(elem).closest(this.paramColSelector),
                editing = $('<div class="param-editing" />').html( $('<div class="loader" />') ),
                offset  = container.offset(),
                hasLocal = yashop.hasLocalStorage();

            container.addClass('active');
            editing.css({
                left: offset.left,
                top: offset.top + container.height()
            });
            $("body").append(editing);

            if(hasLocal) {
                var item = localStorage.getItem("cart-params-"+id);
                if(item) {
                    editing.html(item);
                }
            }

            $.ajax({
                url: this.urlParams,
                data: {
                    id: id
                },
                dataType: 'html',
                success: function(data) {
                    editing.html(data);
                    if(hasLocal)
                        localStorage.setItem("cart-params-"+id,data);
                }
            });
        },

        propertyChange: function(elem)
        {
            var pid = $(elem).attr('data-pid'),
                vid  = $(elem).attr('data-vid');

            $("#pid_"+pid).val(vid);

            $(elem).parent().find('.active').removeClass('active');
            $(elem).addClass('active');

            if( $(elem).hasClass('image') ) {

            }

            this.reload();
        },

        reload: function()
        {
            var count = yashop.cart.row.getNum(this.$row),
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

                if(count > qnt)
                    yashop.showMessage('В наличии всего '+qnt+' шт.','error');

                this.$row.attr('data-price',price);
                if(param.promo_price) {
                    this.$row.attr('data-base-price',param.price);
                }
                if(this.$row.hasClass('active'))
                    yashop.cart.reCalc();

                this.skuId = param.id;
            }
        },

        close: function()
        {
            var sku_id = this.$row.attr('data-id'),
                param   = null;

            for(var i in this.params) {
                if(this.params[i].id === sku_id) {
                    param = this.params[i];
                    break;
                }
            }

            var image = this.$row.find('.cart-image');
            image.attr('src',image.attr('data-default'));

            if(param) {
                var price = (param.promo_price) ? param.promo_price : param.price;

                image.attr('src',param.image);

                this.$row.attr('data-price',price);
                if(param.promo_price)
                    this.$row.attr('data-base-price', param.price);

                if(this.$row.hasClass('active'))
                    yashop.cart.reCalc();
            }
            this.skuId = 0;
            $(this.editWindow).remove();
            this.$row.find(this.paramColSelector).removeClass('active');
        },

        save: function()
        {
            var sku_id = this.$row.attr('data-id'),
                has_inputs  = ($(".input-property").length > 0),
                props = [],
                data = {
                    id: sku_id,
                    params: {}
                };

            if( has_inputs ) {
                $(".input-param").each(function(){
                    var vid = $(this).val(),
                        pid = $(this).attr('name');
                    data.params[ pid ] = vid;
                    var name = $(".input-property-"+vid).attr('title');
                    props.push(name);
                });
            } else {
                this.skuId = this.params[""].id;
            }
            console.log(this.skuId, props);

            if(this.skuId) {
                data.newId = this.skuId;

                this.$row.find(this.paramColSelector).find('p span').each(function(i){
                    $(this).text( props[i] );
                });
                this.$row
                    .attr('data-id',this.skuId)
                    .removeClass('cart-row-'+sku_id)
                    .addClass('cart-row-'+this.skuId)
                    .find('.cart-check').val(this.skuId);
                $.ajax({
                    url: this.urlSaveParams,
                    data: data,
                    success: function(){}
                });
                if(yashop.hasLocalStorage()) {
                    localStorage.removeItem("cart-params-"+sku_id);
                }
                this.skuId = 0;
            }
            $(this.editWindow).remove();
            this.$row.find(this.paramColSelector).removeClass('active');
        }
    };
})(jQuery);