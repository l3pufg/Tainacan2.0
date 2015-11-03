<script> 
$(function(){  
   var $container 	= $('.am-container'),
    $imgs		= $container.find('img').hide(),
    totalImgs	= $imgs.length,
    cnt			= 0;

    $imgs.each(function(i) {
      var $img	= $(this);
      $('<img/>').load(function() {
        ++cnt;
        if( cnt === totalImgs ) {
          $imgs.show();
          $container.montage({
            liquid 	: false,
            fillLastRow	: true,
            alternateHeight	: true,
            alternateWidth	: true,
            alternateHeightRange : {
              min	: 30,
              max	: 248
            },
            alternateWidthtRange : {
              min	: 30,
              max	: 120
            },
            margin : 0
          });

          /*
          * just for this demo:
          */
          $('#overlay').fadeIn(500);
        }
      }).attr('src',$img.attr('src'));
    });
});

</script>
            