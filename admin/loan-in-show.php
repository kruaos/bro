<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container-fluid">
<?php 
function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
}
?>

            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">ข้อมูลการค้ำประกันของ </h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered  table-sm"   width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >No.</th>
                      <th >ผู้กู้</th>
                      <th >บัญชีเลขที่ </th>
                      <th >วันที่ </th>
                      <th >วงเงิน</th>
                      <th >ผู้ค้ำประกัน</th>
                      <th >สถานะบัญชี</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
include('../config/config.php');

  $sql = "select * from Loanbook 
          where Insurer1=".$_GET['memid']." or Insurer2=".$_GET['memid'];
  $query = mysqli_query($link, $sql);
  $num=0;
  while($rs1 = mysqli_fetch_array($query))
        {
?>             
            <tr>
              <td><?php echo  $num=$num+1; ?></td>
              <td><?php 
                  $sql2 = 'select * from member where IDMember='.$rs1['IDMember']; 
                  $query2 = mysqli_query($link,$sql2);
                  while($rs = mysqli_fetch_array($query2))
                  {$fullname=$rs['Title'].$rs['Firstname']." ".$rs['Lastname'];}
              echo  $fullname; 
              ?>
              </td>
              <td>                        
                <a href="loan-pay-show2.php?RefNo=<?php echo $rs1['RefNo'];?>&memid=<?php echo $_GET['memid'];?>">
                <?php echo  $rs1['RefNo']; ?>
                </a>
              </td>
              <td><?php echo  show_day($rs1['CreateDate']); ?></td>
              <td><?php echo  number_format($rs1['Amount']); ?></td>
              <td><?php 
              if ($rs1['Guaranty']==null){
                  $sqli1 = 'select * from member where IDMember='.$rs1['Insurer1']; 
                  $queryi1 = mysqli_query($link,$sqli1);
                    while($rsi1 = mysqli_fetch_array($queryi1))

                  {$fullname=$rsi1['Title'].$rsi1['Firstname']." ".$rsi1['Lastname'];}
                if ($rs1['Insurer1']==$_GET['memid']){ echo "<div class='text-danger'>"; }
                echo "ผู้ค้ำประกันคนที่ 1 ".$fullname."<br>";
                if ($rs1['Insurer1']==$_GET['memid']){ echo "</div>" ;}

                  $sqli2 = 'select * from member where IDMember='.$rs1['Insurer2']; 
                  $queryi2 = mysqli_query($link,$sqli2);
                    while($rsi2 = mysqli_fetch_array($queryi2))

                  {$fullname=$rsi2['Title'].$rsi2['Firstname']." ".$rsi2['Lastname'];}
                if ($rsi2['Insurer2']==$_GET['memid']){ echo "<div class='text-danger'>"; }
                echo "ผู้ค้ำประกันคนที่ 2 ".$fullname."<br>";
                if ($rsi2['Insurer2']==$_GET['memid']){ echo "</div>"; }

              }
               ?></td>
               <td><?php echo  $rs1['LoanStatus']; ?></td>
            </tr>

<?php 
        } 
  mysqli_close($link);
?>                    
                  </tbody>
                </table>
             <a href="loan-show.php" class="btn btn-danger" >ย้อนกลับ</a>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>