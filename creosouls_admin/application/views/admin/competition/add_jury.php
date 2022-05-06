<!-- <style>
.label-wrapper{
text-align: left;
}
.requiredClass{
color: red;
}

#juryModal .modal-body{
  margin-left: -18px;
}


#juryModal {
   z-index: 9997;
}

  </style>

<div class="modal fade" id="juryModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
      <form class="form-horizontal" style="margin-top:50px;">
          <div class="form-group">
              <label class="col-sm-2 control-label" for="juryName">Jury Name:</label>
              <div class="col-sm-10">
                  <input type="juryName" class="form-control" id="juryName">
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="juryEmail">Jury Email:</label>
              <div class="col-sm-10">
                  <input type="juryEmail" class="form-control" id="juryEmail">
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="juryName">Jury Photo:</label>
              <div class="col-sm-10">
                 <input onchange="readURL(this)" type="file" placeholder="Jury Photo." id="juryPhoto" name="juryPhoto">
                 <span style="color: green; float: left;">(Note:- Allowed file types " gif, jpg, png, jpeg ", Allowed size 2MB)</span>
                 <br/>
                 <img width="100" height="100" class="preview" id="juryPhoto" src="#" alt="" />
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="juryWriteUp">Write Up:</label>
              <div class="col-sm-10">
                  <textarea placeholder="juryWriteUp" id="juryWriteUp" name="juryWriteUp" class="required"></textarea>
              </div>
          </div>
          <div class="form-group">
               <a href="javascript:void('0')" class="btn btn-default" data-dismiss="modal">Cancel</a>
               <a href="javascript:void('0')" class="btn btn-danger" data-dismiss="submodal">Submit</a>
           </div>
      </form>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal --> -->


<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Remote file for Bootstrap Modal</title>
</head>
<body>
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Modal title</h4>
            </div>      <!-- /modal-header -->
            <div class="modal-body">
            <p>Excitavit hic ardor milites per municipia plurima, quae isdem conterminant, dispositos et castella, sed quisque serpentes latius pro viribus repellere moliens, nunc globis confertos, aliquotiens et dispersos multitudine superabatur ingenti.</p>
            </div>      <!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>      <!-- /modal-footer -->
        </div>         <!-- /modal-content -->
    </div>     <!-- /modal-dialog -->
</body>
</html>