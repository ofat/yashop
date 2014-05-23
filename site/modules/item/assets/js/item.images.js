yashop.item.images = (function($){
    return {
        isActive: true,

        $smallImages: $('#small-images'),
        $mainImage: $('#main-image'),
        $preLoad: $('a[rel="preload"]'),

        init: function() {
            var me = this;
            this.preLoad();
            this.$smallImages.find("a").hover(function(e){
                me.zoom(this);
                e.preventDefault();
            });
            this.$smallImages.find("a").click(function(e){
                me.zoom(this);
                e.preventDefault();
            });
        },

        preLoad: function()
        {
            var images = [],
                i = 0,
                href;
            this.$preLoad.each(function(){
                href = this.href;
                images[i] = new Image();
                images[i].src = href;
                i++;
                images[i] = new Image();
                images[i].src = href+'_390x390.jpg';
                i++;
            });
        },

        zoom: function(elem)
        {
            var href = elem.href;
            this.$smallImages.find("a").removeClass('active');
            $(elem).addClass('active');
            this.$mainImage.find("img").attr("src",href+'_390x390.jpg');
            this.$mainImage.find("a").attr("href",href);
        }
    };
})(jQuery);