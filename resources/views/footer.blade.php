<div class="app-wrapper-footer ftrNav">
                    <div class="app-footer ftrWrap">  
                        <div class="app-footer__inner ftrBtmTxt">
                            Copyright <?php echo date('Y');?> Airport Control Tower API Dashboard | All rights reserved.
                        </div>    
                    </div>
                </div>

<script type='text/javascript' src='https://code.jquery.com/jquery-3.7.0.js' id='jquery-js'></script>

<script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/taskms.js') }}"></script>

    <script>
    upload_image.onchange = evt => {
      const [file] = upload_image.files
      if (file) {
        blahPhoto.src = URL.createObjectURL(file)
      }
    }
</script>
<script>
$(document).on("input", "#PhoneNumber", function (e) {
  this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1');
  $(this).attr({"minlength": "10","maxlength": "18"});
  });
</script>

<script>
$(document).on("input", "#NextOfKinNamePhone", function (e) {
  this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1');
  $(this).attr({"minlength": "10","maxlength": "18"});
  });
</script>