<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
?>
<div class="container-fluid">
<?php 
$IDMemberSql = "SELECT * from member ORDER BY IDMember ASC";
$LoanBookSql="SELECT * from loanbook where LoanStatus ='N' Order by CreateDate " ;
$query = mysqli_query($link, $LoanBookSql);
$total_record=$query->num_rows;
?>
    <h6 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิกเงินกู้ จำนวน <?php echo $total_record; ?> ราย </h6>
    
<!-- loop  -->       
<?php 
$num=1; 
$query = mysqli_query($link, $LoanBookSql);
while($rs1 = mysqli_fetch_array($query)){
    $IDMember=$rs1['IDMember'];
    $RefNo=$rs1['RefNo'];
    
    $FullNameSql = "SELECT * from member where IDMember='$IDMember' ";
    $FullNameQuery = mysqli_query($link, $FullNameSql);
    while($FNQ = mysqli_fetch_array($FullNameQuery)){
        $FullName=$FNQ['Title'].$FNQ['Firstname']." ".$FNQ['Lastname'] ;
    } 
    $LastLoanPaymentSql="SELECT * from loanpayment where RefNo='$RefNo' ORDER BY IDLoanPay DESC LIMIT 0,1";
    $LastLoanPaymentQuery = mysqli_query($link, $LastLoanPaymentSql);
    while($LLPQ = mysqli_fetch_array($LastLoanPaymentQuery)){
        $CreateDate= $LLPQ['CreateDate'];
        $IDLoanPay= $LLPQ['IDLoanPay'];
        echo "('','$IDMember','$RefNo','$CreateDate','$IDLoanPay'),";
    }
    echo "<br>";
    $num++;
}
exit();

    ?>      
       
        <tr>
            <td><?php echo $num; ?></td>
            <td><?php echo $IDMember; ?></td>
            <td><?php echo $RefNo; ?>
            </td>
            <td>
            <?php 
                while($LLPQ = mysqli_fetch_array($LastLoanPaymentQuery)){
                    $CreateDate= $LLPQ['CreateDate'];
                    $IDLoanPay= $LLPQ['IDLoanPay'];
                }
                echo $CreateDate;   
            ?>
        </td>
        <td><?php echo $IDLoanPay; ?>
        </td>                   
            </td>
        </tr>

<?php 
    $num++;    
  mysqli_close($link);
?>                    

            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>