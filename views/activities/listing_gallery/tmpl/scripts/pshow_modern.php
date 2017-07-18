<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
?>
<script type="text/javascript">
(function($)
{
    $(function()
    {
        var slider = $('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> #wpl_gallery_container<?php echo $this->property_id; ?>').lightSlider(
        {
            pause : 4000,
            auto: <?php echo (($this->autoplay) ? 'true' : 'false'); ?>,
            mode: 'fade',
            item: 1,
            thumbItem:<?php echo (($this->thumbnail_numbers) ? $this->thumbnail_numbers : 20); ?>,
            loop: true,
            autoWidth: true,
            adaptiveHeight: true,
            gallery: <?php echo (($this->thumbnail and count($this->gallery)) ? 'true' : 'false'); ?>,
            onSliderLoad: function(el)
            {
                $('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> #wpl_gallery_container<?php echo $this->property_id; ?> li').show();
                if($('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> #wpl_gallery_container<?php echo $this->property_id; ?>').find('.gallery_no_image').length == 0)
                {
                    el.lightGallery(
                        {
                            selector: '#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> #wpl_gallery_container<?php echo $this->property_id; ?> .lslide',
                            thumbWidth: <?php echo $this->thumbnail_width ?>
                        });
                }
                <?php if($this->thumbnail and count($this->gallery)): ?>
                    $('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> .lSSlideOuter').append('<div class="wpl-lSSlider-thumbnails"><div class="lSAction"><a class="lSPrev"></a><a class="lSNext"></a></div><div class="wpl-lSSlider-thumbnails-inner"></div></div>');
                    $('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> .lSSlideOuter .wpl-lSSlider-thumbnails-inner').append($('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> .lSPager'));
                    $('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> .wpl-lSSlider-thumbnails .lSPrev').on('click', function () {
                        //$('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> .lSSlideWrapper .lSPrev').trigger('click');

                    });
                    $('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> .wpl-lSSlider-thumbnails .lSNext').on('click', function () {
                        //$('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> .lSSlideWrapper .lSNext').trigger('click');
                        var id = slider.getCurrentSlideCount();
                        id = id + 5;
                        slider.goToSlide(id);
                    });

                $('#wpl_gallery_wrapper-<?php echo $this->activity_id; ?> .wpl-lSSlider-thumbnails .lSPager li').on('hover',function(){

                });

                <?php endif; ?>
            }

        });
    });
})(jQuery);
</script>