<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=d6qn2r5d5w1psh1q3lcdkcxt4vspz2j0bt3ev90kv40ddunw"></script>
<script>
tinymce.init({
 selector: '#mytextarea',
 document_base_url: "<?=Config::get('site_url');?>",
 branding: false,
 statusbar: false,
 menubar: false,
plugins: [
   "advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste"
],
   toolbar1: "bold italic | anchor | link image | charmap | superscript subscript | table",
   toolbar2: 'searchreplace | styleselect | bullist numlist'
});
</script>


<form method="post">
  <textarea id="mytextarea">Hello, World!</textarea>
</form>
