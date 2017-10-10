<!DOCTYPE html> 
<html lang="en"> 
    <head> 
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Script-Type" content="text/javascript"/>
    <!--REACT -->
    <script src="https://fb.me/react-15.1.0.min.js"></script>
    <script src="https://fb.me/react-dom-15.1.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>
    <!-- JS -->
    <!--script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!--script src="vendor/angular-1.5.8.min.js"></script>
    <script src="vendor/angular-messages-1.5.8.min.js"></script-->
    <!--script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script-->
    
    <!--script src="https://code.angularjs.org/1.5.8/angular-route.min.js"></script-->

    <!--script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.js"></script-->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/angular-1.5.8.min.js"></script>
    <!--script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script-->
    <script src="vendor/angular-route-1.5.8.min.js"></script>
    <script src="vendor/angular-messages-1.5.8.min.js"></script>
    <script src="vendor/notifier.js"></script> 
    <script src="vendor/jquery-3.1.1.min.js"></script>
    <!-- load angular -->

    <title>Romeo (Laravel and Angular based shoppinglist application)</title>

    <!-- CSS -->
    <!--link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.7.7/css/bootstrap.min.css"--> <!-- load bootstrap via cdn3.1.0 -->

    <!--link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"--> <!-- load fontawesome ic_list_black_24px.svg-->
    <link rel="stylesheet" href="themes/style.css"/>
    <link rel="icon" href="themes/logo1.png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro">
    <!--link rel="icon" href="Anchor.ico" type="image/x-icon"/--> 
    <!--link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"-->
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"-->
    <link href="https://fonts.googleapis.com/css?family=Spirax" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Jim+Nightshade|Spirax" rel="stylesheet"> 
    <!--link href="http://allfont.net/allfont.css?fonts=linotypezapfino-one" rel="stylesheet" type="text/css" /-->
    <style>
        body        { padding-top:30px; }
        form        { padding-bottom:20px; }
        .comment    { padding-bottom:20px; }
    </style>
    
    
    
    <!-- ANGULAR -->
    <!-- all angular resources will be loaded from the /public folder -->
        <script src="js/controllers/homeCtrl.js"></script>
        <script src="js/controllers/authCtrl.js"></script>
        <script src="js/controllers/shopCtrl.js"></script>
        <script src="js/controllers/listaCtrl.js"></script>
        <script src="js/controllers/productCtrl.js"></script>
        <script src="js/services/authService.js"></script>
        <script src="js/services/shopService.js"></script>
        <script src="js/services/listaService.js"></script>
        <script src="js/services/productService.js"></script>
        <script src="js/app.js"></script> <!-- load our application -->
      
</head> 
<!-- declare our angular app and controller --> 
<body class="full_screen">
    <div class="container" ng-app="romeoApp" ng-controller="menuController"> 

    <header class="header blue_gradient">
        <nav class="navbar navbar-default up" id="myNavbar" ng-if="userMaybeLoggedIn">
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button> 
                <!--div id="welcome">
                </div-->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" id="myText">
                  <li class="dropdown">
                    <a href="#/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Home <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="myText">
                      <li><a ng-click="temporaryLogoutFn()" href="">Kirjaudu ulos</a></li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Listat <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="myText">
                    <div ng-if="shops.length > 0">
                    <input type="text" ng-model="filterText" placeholder="Etsi nimellä"></input>
                      
                      <select size="2" ng-model="shop"
                                      ng-options="shop.id as shop.shop for shop in shops | filter:filterText"
                                      ng-change="scrollToName(shop)">
                                       <option value="">-- Valitse kaikista  kaupoista --</option>
                     </select>
                     </div>
                      <div ng-if="shops.length < 1">
                      <p>Ei kauppoja listalla</p>
                      </div>

                    </ul>
                  </li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tuotteet <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="myText">
                      <li><a href="#/show-products">Kaikki tuotteet</a></li>
                    </ul>
                  </li>
                  </li>
                </ul>
              </div><!-- /.navbar-collapse -->
            <!--/div--><!-- /.container-fluid -->
          </nav>
         </header>
       <div class="body">
        <div id="views" ng-view></div>
        <!--alaosa -->
       <div class="alaosa" style="height: 20%;"></div>
        </div>
    <notifier></notifier>
    </div> <!-- container-->
    
    <footer class="footer">desing by © taianomainen.com</footer> 

<!--  REACT -->
   <!--script type="text/babel">
    var Circle = React.createClass({
      render: function() {
          var circleStyle = {
            paddingTop: 17,
            paddingLeft: 5,
            margin: 0,
            display: "inline-block",
            backgroundColor: this.props.bgColor,
            borderRadius: "50%",
            width: 80,
            height: 80,
          };
 
          return (
            <div style={circleStyle}>
            <a class="navbar-brand different" href="index.php#/" id="myName">Rome</a>
            </div>
          );
        }
    });
 
    var destination = document.querySelector("#welcome");

    
    var colors = ["#F7E98E", "#DFF0D8", "#575757", "tomato"];
      
     var ran = Math.floor(Math.random() * colors.length);
 
     var renderData = [];
 
for (var i = 0; i < 1; i++) {
  renderData.push(<Circle bgColor={colors[ran]}/>);
}


ReactDOM.render(
  <div>
    {renderData}
  </div>,
  destination
);
  </script-->

</body> 
</html>