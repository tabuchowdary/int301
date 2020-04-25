<!DOCTYPE html>
<html>

<head>
  <title>Electricity Bill</title>
  <style>

  .error
  {
    color: red;
  }

  .bill
  {
  	max-width:650px;
  	width:100%;
  	margin:0 auto;
  	position:relative;
    border:1px solid black;
    border-radius: 5px;
    background-color: #FFB6C1;
    padding: 20px;
  }


  button[type=generate]
  {
    background-color: #BF94E4;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .button, h3
  {
    text-align: center;
  }

  </style>
</head>

<body>

  <?php

  $error = "";
  $units = "";
  $cost = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if (empty($_POST["units"]))
    {
      $error = "Input is required";
    }
    else
    {
      $units = test_input($_POST["units"]);

      if (!preg_match('/^[0-9]+$/', $units))
      {
        $error = "Input must be an integer";
      }

      if($units < 0)
      {
        $error = "Input must be non-negative";
      }
      else if($units < 51)
      {
        $cost = $units * 9;
      }
      else if($units < 101)
      {
        $cost = 450 + ($units - 50)*12;
      }
      else {
        $cost = 1050 + ($units - 100)*15;
      }
    }

  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>

  <div class="bill">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <h3>Electricity Bill Generator</h3>
      <h4>Know your Electricity Bill</h4>
      <p>Upto 50 units --> Rs. 9 per unit</p>
      <p>50 - 100 units --> Rs. 12 per unit</p>
      <p>Above 100 units --> Rs. 15 per unit</p>
      <table>
        <tr>
          <td>Consumption :</td>
          <td><input type="text" name="units" placeholder="Enter Units Consumed" value="<?php echo isset($_POST['units']) ? $_POST['units'] : '' ?>">
            <span class="error">* <?php echo $error;?></span>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <?php

              if(isset($_POST['generate']) && $error == "")
              {
                echo nl2br("\n Your Electricity Bill is Rs. " . $cost);
              }

               ?>
          </td>
        </tr>
      </table>
      <p><span class="error">* Required field</span></p>
      <div class="button">
        <button name="generate" type="generate">Generate</button>
      </div>
    </form>
  </div>

</body>

</html>
