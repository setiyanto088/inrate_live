<style>
* {
    box-sizing: border-box;
}

body {
    background-color: #474e5d;
    font-family: Helvetica, sans-serif;
}

/* The actual timeline (the vertical ruler) */
.timeline {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
    content: '';
    position: absolute;
    width: 6px;
    background-color: red;
    top: 0;
    bottom: 0;
    left: 0%;
    margin-left: -3px;
}

/* Container around content */
.container {
    padding: 10px 40px;
    position: relative;
    background-color: inherit;
    width: 50%;
}

/* The circles on the timeline */
.container::after {
    content: '';
    position: absolute;
    width: 25px;
    height: 25px;
    right: 0px;
    background-color: #eee;
    border: 4px solid #FF9F55;
    top: 15px;
    border-radius: 50%;
    z-index: 1;
}

/* Place the container to the left */
.left {
    left: 0;
}

/* Place the container to the right */
.right {
    left: -24.5%;
}


/* Add arrows to the right container (pointing left) */
.right::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    left: 30px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
.right::after {
    left: -16px;
}

/* The actual content */
.content {
    padding: 20px 30px;
    background-color: #eee;
    position: relative;
    border-radius: 6px;
	font-size: 10px;
	margin: 1px;
}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
    left: 31px;
  }
  
  /* Full-width containers */
  .container {
    width: 100%;
    padding-left: 70px;
    padding-right: 25px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  .container::before {
    left: 60px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
    left: 15px;
  }
  
  /* Make all right containers behave like the left ones */
  .right {
    left: 0%;
  }
}
</style>
<?php //print_r($detailuser);?>
		<div class="row" >
			<div class="col-sm-12">
				<div class="form-group">
					<div class="col-sm-2">Name </div>
					  <div class="col-sm-10">
						<span>: <?php echo $detailuser[0]['nama']?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">Email</div>
					  <div class="col-sm-10">
						<span> : <?php echo $detailuser[0]['email']?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">Packet</div>
					  <div class="col-sm-10">
						<span> : <?php echo $detailuser[0]['role']?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">Type User</div>
					  <div class="col-sm-10">
						<span> : <?php if($detailuser[0]['activation_id'] == "1"){ echo "Trial"; }else{ echo "Paid"; }?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">Paid Date</div>
					  <div class="col-sm-10">
						<span> : <?php echo $detailuser[0]['paid_date']?></span>
					  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">Expired Date</div>
					  <div class="col-sm-10">
						<span> : <?php echo $detailuser[0]['expired_date']?></span>
					  </div>
				</div>
			
				
				
			</div>				
		</div>
		
			
<div class="timeline">
  <?php 
  if(isset($history)){
  foreach($history as $hs){?>
  <div class="container right">
    <div class="content" >
      <h2 ><?php echo $hs['date_log'];?></h2>
      <p><?php echo $hs['status'];?></p>
    </div>
  </div>
  <?php }}?>
</div>
				
