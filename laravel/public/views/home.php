
    
 
<div class="row" ng-if="!userMaybeLoggedIn">
    <div class="rivi">  
        <div class='window auto'>
	       <div class="content">
                <p id="myName">Romeo </p>
                <a class="ghost-round full-width" href="#/signin">Kirjaudu sisään</a>
	       </div>
        </div>
    </div>
    <div class="rivi">  
        <div class='window'>
                <div class="portfolio-hover-content eitausta">
                    <h4 class="service-heading">Romeo</h4>
                    <p class="text-muted gold">Romeo on sovellusharjoitustyö, jossa back-end ja front-end kommunikoivat rest-apin välityksella keskenään. Front-end on toteutettu Angular JS:llä ja back-end Laravelillä. 
                    </p>
                </div>
        </div>
        <div class='window'>   
                <div class="portfolio-hover-content eitausta">
                    <h4 class="service-heading"> Mitä Romeolla voi tehdä?</h4>
                    <p class="text-muted gold">Romeolla lisätään valmiiksi luotuja kauppoja omalle listalle. Tämän jälkeen kaupoille voidaan luoda listoja ja listoille tuotteita. </p>
                </div>
        </div>
         <div class='window'>
                <div class="portfolio-hover-content eitausta">
                    <h4 class="service-heading">Huom!</h4>
                    <p class="text-muted gold">Sovellus ei ole valmis. Vaan sen avulla yhäkin harjoitellaan erilaisia asioita... </p>
                </div>
        </div>
</div>
</div>


<section id="portfolio" class="bg-light-gray" ng-controller="shopsController" ng-if="userMaybeLoggedIn">
    <!--div class="container"-->
        <div class="row" >
            <div class="col-md-12 col-sm-12 portfolio-item">
                <!--h3>Kaikki kaupat </h3-->
                <div class="portfolio-link">
                    <input class="input-line full-width" type="text" ng-model="filterText" placeholder="Etsi nimellä"></input>
                    <div class="reunaeka">
                        <div class="portfolio-hover-content">
                            <div ng-if="shops.length > 0">

                                <!--ol> 
                                    <li ng-repeat="shop in shops | filter:filterText | orderBy: 'nimi' track by $index" title="Katso kaupan listoja">
                                        <a href="#/showshop/{{shop.shop_id}}">
                                        {{shop.shop}}
                                        </a>
                                    </li>
                                </ol-->

                                <ol class="none"> 
                                    <li ng-repeat="shop in shops | filter:filterText | orderBy: 'nimi' track by $index" title="Katso kaupan listoja">
                                        <a href="#/showshop/{{shop.shop_id}}">
                                        {{shop.shop}}
                                        </a>
                                    </li>
                                </ol>
                            </div>
                            <div ng-if="shops.length < 1">
                                <p>Ei kauppoja.</p>
                            </div>
                        </div>
                    </div>
                    <img src="themes/img/sivut.jpg" class="img-responsive" alt="">
                </div>
                 <div class="portfolio-caption">
                        <h4>Kaikki kaupat</h4>
                        <p class="text-muted">Etsi kauppaa nimellä</p>
                </div>
            </div>
            <!--/div-->
        </div>
    <!--/div-->
</section>