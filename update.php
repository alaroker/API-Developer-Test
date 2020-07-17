<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values

$county = $country = $town = $description = $details = $address = $image = $latitude = $longitude = $bedrooms = $bathrooms = $price = $type = $saleorrent = "";
$county_err = $country_err = $town_err = $description_err = $details_err = $address_err = $image_err = $latitude_err = $longitude_err = $bedrooms_err = $bathrooms_err = $price_err = $type_err = $saleorrent_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate county
   
    $input_county = trim($_POST["county"]);
    if(empty($input_county)){
        $county_err = "Please enter a county.";     
    } else{
        $county = $input_county;
    }
    
     
     // Validate country
     $input_country = trim($_POST["country"]);
     if(empty($input_country)){
         $country_err = "Please enter a country.";     
     } else{
         $country = $input_country;
     }
     
     // Validate town
     $input_town = trim($_POST["town"]);
     if(empty($input_town)){
         $town_err = "Please enter a town.";     
     } else{
         $town = $input_town;
     }
 
     // Validtate description
     $input_description = trim($_POST["description"]);
     if(empty($input_description)){
         $description_err = "Please enter a description.";     
     } else{
         $description = $input_description;
     }
 
     // Validate details
 
     $input_details = trim($_POST["details"]);
     if(empty($input_details)){
         $details_err = "Please enter details.";     
     } else{
         $details = $input_details;
     }
 
 // Validate address
 
 $input_address = trim($_POST["address"]);
 if(empty($input_address)){
     $address_err = "Please enter address.";     
 } else{
     $address = $input_address;
 }
 
 
 
     // validate image
 
     $input_image = trim($_POST["image"]);
     if(empty($input_image)){
         $image_err = "Please enter an image.";     
     } else{
         $image = $input_image;
     }
 
     // validate latitude
 
     $input_latitude = trim($_POST["latitude"]);
     if(empty($input_latitude)){
         $latitude_err = "Please enter a latitude.";     
     } else{
         $latitude = $input_latitude;
     }
 
     // validate longitude
 
     $input_longitude = trim($_POST["longitude"]);
     if(empty($input_longitude)){
         $longitude_err = "Please enter a longitude.";     
     } else{
         $longitude = $input_longitude;
     }
     
     // validate bedrooms
 
     $input_bedrooms = trim($_POST["bedrooms"]);
     if(empty($input_bedrooms)){
         $bedrooms_err = "Please enter a bedroom.";     
     } else{
         $bedrooms = $input_bedrooms;
     }
 
     // validate bathrooms
 
     $input_bathrooms = trim($_POST["bathrooms"]);
     if(empty($input_bathrooms)){
         $bathrooms_err = "Please enter a bathroom.";     
     } else{
         $bathrooms = $input_bathrooms;
     }
 
     // validate price
 
     $input_price = trim($_POST["price"]);
     if(empty($input_price)){
         $price_err = "Please enter a price.";     
     } else{
         $price = $input_price;
     }
 
     // validate type
 
     $input_type = trim($_POST["type"]);
     if(empty($input_type)){
         $type_err = "Please enter a type.";     
     } else{
         $type = $input_type;
     }
 
 // validate sale or rent
 
 $input_saleorrent = trim($_POST["saleorrent"]);
 if(empty($input_saleorrent)){
     $saleorrent_err = "Please enter whether sale or rent";     
 } else{
     $saleorrent = $input_saleorrent;
 }
 
    
    // Check input errors before inserting in database
    if(empty($county_err) && empty($country_err) && empty($town_err) && empty($description_err) && empty($details_err) && empty($address_err) && empty($image_err) && empty($latitude_err) && empty($longitude_err) && empty($bedrooms_err) && empty($bathrooms_err) && empty($price_err) && empty($type_err) && empty($saleorrent_err)){
        // Prepare an update statement
        $sql = "UPDATE tbl_sample SET county=?, country=?, town=?, description=?, details=?, address=?, image=?, latitude=?, longitude=?, bedrooms=?, bathrooms=?, price=?, type=?, saleorrent=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssssssssi", $param_county, $param_country, $param_town, $param_description, $param_details, $param_address, $param_image, $param_latitude, $param_longitude, $param_bedrooms, $param_bathrooms, $param_price, $param_type, $param_saleorrent, $param_id);
            
            // Set parameters
            $param_county = $county;
            $param_country = $country;
            $param_town = $town;
            $param_description = $description;
            $param_details = $details;
            $param_address = $address;
            $param_image = $image;
            $param_latitude = $latitude;
            $param_longitude = $longitude;
            $param_bedrooms = $bedrooms;
            $param_bathrooms = $bathrooms;
            $param_price = $price;
            $param_type = $type;
            $param_saleorrent = $saleorrent;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM tbl_sample WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                $county = $row["county"];
                $country = $row["country"];
                $town = $row["town"];
                $description = $row["description"];
                $details = $row["details"];
                $address = $row["address"];
                $image = $row["image"];
                $latitude = $row["latitude"];
                $longitude = $row["longitude"];
                $bedrooms= $row["bedrooms"];
                $bathrooms = $row["bathrooms"];
                $price = $row["price"];
                $type = $row["type"];
                $saleorrent = $row["saleorrent"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                       
                    <div class="form-group <?php echo (!empty($county_err)) ? 'has-error' : ''; ?>">
                            <label>County</label>
                            <input type="text" name="county" class="form-control" value="<?php echo $county; ?>">
                            <span class="help-block"><?php echo $county_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                            <label>Country</label>
                            <textarea name="country" class="form-control"><?php echo $country; ?></textarea>
                            <span class="help-block"><?php echo $country_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($town_err)) ? 'has-error' : ''; ?>">
                            <label>Town</label>
                            <input type="text" name="town" class="form-control" value="<?php echo $town; ?>">
                            <span class="help-block"><?php echo $town_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
                            <span class="help-block"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($details_err)) ? 'has-error' : ''; ?>">
                            <label>Details</label>
                            <textarea name="details" class="form-control"><?php echo $details; ?></textarea>
                            <span class="help-block"><?php echo $details_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Image</label>
                            <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                            <span class="help-block"><?php echo $image_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($latitude_err)) ? 'has-error' : ''; ?>">
                            <label>Latitude</label>
                            <textarea name="latitude" class="form-control"><?php echo $latitude; ?></textarea>
                            <span class="help-block"><?php echo $latitude_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($longitude_err)) ? 'has-error' : ''; ?>">
                            <label>Longitude</label>
                            <input type="text" name="longitude" class="form-control" value="<?php echo $longitude; ?>">
                            <span class="help-block"><?php echo $longitude_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($bedrooms_err)) ? 'has-error' : ''; ?>">
                            <label>Bedrooms</label>
                            <input type="text" name="bedrooms" class="form-control" value="<?php echo $bedrooms; ?>">
                            <span class="help-block"><?php echo $bedrooms_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($bathrooms_err)) ? 'has-error' : ''; ?>">
                            <label>Bathrooms</label>
                            <textarea name="bathrooms" class="form-control"><?php echo $bathrooms; ?></textarea>
                            <span class="help-block"><?php echo $bathrooms_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
                            <label>Type</label>
                            <input type="text" name="type" class="form-control" value="<?php echo $type; ?>">
                            <span class="help-block"><?php echo $type_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($saleorrent_err)) ? 'has-error' : ''; ?>">
                            <label>Sale Or Rent</label>
                            <textarea name="saleorrent" class="form-control"><?php echo $saleorrent; ?></textarea>
                            <span class="help-block"><?php echo $saleorrent_err;?></span>
                        </div>
                        


                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>