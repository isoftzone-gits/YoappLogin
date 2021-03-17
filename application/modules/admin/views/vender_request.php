<div class="content-wrapper">
  <section class="content-header">
      <h1>
        Vender Request
      </h1>
    </section>
</div>
<section class="content"> 
    <div class="row">
    <div class="col-md-12">
     <table >
         <thead>  
        <th>Vender id</th>     
        <th>Vender name</th>  
        <th>Approval</th>
        </thead>
        <?php
        $i = 0;
       foreach($data as $row)
        {
          $i++;
      
        ?>
        <tbody>
        <tr>
          <td>
            <?php echo $row->vender_id;?>
          </td>
          <td>
            <?php echo $row->vender_name;?>
          </td>
        </tr>
       </tbody>
       <?php }?>
</table>
        </div>
        </div>
        </section>
        