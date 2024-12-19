<?php include('includes/header.php') ?>



<div class="main-ctn">

<div class="new-sale-form-ctn">

    <form action="" method="POST" class="new-sale-form">
        <div class="new-sale-form-title">
            Update Form
        </div>

    
        <div class="new-sele-form-body">
            <div class="new-sele-form-input-ctn">
                <label class="new-sele-form-input-label" for="product">Product</label>


                <select type="text"     class="new-sale-form-input  <?php if(isset($_POST['submit'])){if ($product === '' ){ echo 'err-style'; };} ?>" name="product" placeholder="Enter product">

                    <?php foreach($products as $item): ?>
                    <option value="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></option>
                    <?php endforeach; ?>


                </select>   


                <span class="err-message"><?php if(isset($_POST['submit'])){if($product === ""){ echo   $productErr ; }}; ?></span>

            </div>

            <div class="new-sele-form-input-ctn">
                <label class="new-sele-form-input-label" for="quantity">Quantity (Wrap pack)</label>
                <input type="number" class="new-sale-form-input <?php if(isset($_POST['submit'])){if ($quantity === '' ){ echo 'err-style'; };} ?> " name="quantity" placeholder="Enter quantity">
                <span class="err-message"><?php if(isset($_POST['submit'])){if($quantity === ""){ echo   $quantityErr ; }}; ?></span>
            
            </div>

            <div class="new-sele-form-input-ctn">
                <label class="new-sele-form-input-label" for="customer_name">Customer Name</label>
                <input type="text" class="new-sale-form-input  <?php if(isset($_POST['submit'])){if ($customer_name === '' ){ echo 'err-style'; };} ?>" name="customer_name" placeholder="Enter Customer Name">
                <span class="err-message"><?php if(isset($_POST['submit'])){if($customer_name === ""){ echo   $customer_nameErr ; }}; ?></span>

            </div>

            <div class="new-sele-form-input-ctn">
                <label class="new-sele-form-input-label" for="customer_email">Customer Email</label>
                <input type="email" class="new-sale-form-input  <?php if(isset($_POST['submit'])){if ($customer_email=== '' ){ echo 'err-style'; };} ?>" name="customer_email" placeholder="Enter Customer Email">
                <span class="err-message"><?php if(isset($_POST['submit'])){if($customer_email === ""){ echo   $customer_emailErr ; }}; ?></span>

            </div>

            <div class="new-sele-form-input-ctn">
                <label class="new-sele-form-input-label" for="customer_contact_number">Customer Contact Number</label>
                <input type="number" class="new-sale-form-input  <?php if(isset($_POST['submit'])){if ($customer_contact_number === '' ){ echo 'err-style'; };} ?>" name="customer_contact_number" placeholder="Enter Customer Contact Number">
                <span class="err-message"><?php if(isset($_POST['submit'])){if($customer_contact_number === ""){ echo   $customer_contact_numberErr  ; }}; ?></span>

            </div>

            
            <div class="new-sele-form-input-ctn">
                <label class="new-sele-form-input-label" for="customer_address">Customer Address</label>
                <input type="text" class="new-sale-form-input  <?php if(isset($_POST['submit'])){if ($customer_address === '' ){ echo 'err-style'; };} ?>" name="customer_address" placeholder="Enter Customer Addres">
                <span class="err-message"><?php if(isset($_POST['submit'])){if($customer_address === ""){ echo   $customer_addressErr ; }}; ?></span>

            </div>

            <div class="new-sele-form-submit-ctn">
               <a href="">
                <input type="submit" name="submit"  class="new-sale-form-submit btn" value="Next">
               </a>
            </div>

            
        </div>

    </form>

</div>

</div>

<?php include 'includes/footer.php'; ?>


