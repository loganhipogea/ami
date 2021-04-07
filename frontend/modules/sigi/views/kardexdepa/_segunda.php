<div>
   <?php if($model->hasAttachments()) { 
       //echo $model::className();die();
       echo $model->files[0]->urlTempWeb ;
       
       
      // echo "http://www.diar-gestion.com/frontend/uploads/store/95/39/ec/954393ec878877fe9bd7393b7a6302b1.pdf" ;?>
   <!-- <embed src="http://www.diar-gestion.com/frontend/uploads/store/95/39/ec/954393ec878877fe9bd7393b7a6302b1.pdf"  type="application/pdf" width="100%" height="600px" />-->
     <!--  <embed src=""  type="application/pdf" width="100%" height="600px" />-->
       <?php  echo $this->render('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $model->files[0]->urlTempWeb,
                         'width' => 700,
                            'height' => 900,
            ]); ?> 
         <?php } ?>
</div>

