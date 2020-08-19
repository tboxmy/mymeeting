<?php 
if(isset($javascript)){
    echo($javascript->link("tiny_mce/tiny_mce.js"));
?>
    <script language="javascript" type="text/javascript">
<?php 
    if(isset($preset) && $preset == "basic") {
        $options = '
            mode : "textareas",
            theme : "advanced",
            theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,indent,outdent,|,undo,redo,|,link,unlink",
            theme_advanced_buttons2 : "formatselect,|,fontselect,fontsizeselect,|,code",
            theme_advanced_buttons3 : "",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
            content_css : "/css/'.$this->layout.'.css" ';
    }
    else{
        $options = 'theme: "simple",
                    mode: "textareas",
                    convert_urls : false ';
    }
?>
    tinyMCE.init({<?php echo($options); ?>});
    </script> 
<?php
}
?>
