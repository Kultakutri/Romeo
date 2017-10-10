

    <section id="portfolio" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Tuotteet</h2>
                    <!--h3 class="section-subheading text-muted black">Vahvuuteni ovat tarkkuus, pitkäjänteisyys ja visuaalisuus. Kehitän ohjelmointi osaamistani erityisesti front-end ja designer puolelle. Pidän uuden oppimisesta ja haasteista.</h3-->
                </div>
            <!--/div>
            <div class="row"-->
                <div class="col-sm-6 col-md-4 portfolio-item">
                
                    <div class="portfolio-link">
                        <div class="reuna">
                            <div class="portfolio-hover-content">
                                
                                <!--div class="input-fields"-->
                                    <input type="text" ng-model="filterText" class="input-line full-width" placeholder="Etsi tuote nimellä"></input>
                                <!--/div-->

                            </div>
                        <!--/div-->


                        

                            <div ng-controller="allProductsController">
                                <h4>Kaikki tuotteet:</h4>
                                <div ng-if="items.length > 0">
                                    <ul class="list-inline">
                                        <li class="listline" ng-repeat="item in items | filter:filterText | orderBy: 'nimi' track by $index" title="Muokkaa tuotetta">
                                            <a href="#/add_product/{{item.id}}">
                                                           {{item.nimi}} 
                                            </a>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div ng-if="items.length < 1">
                                    <p>Ei tuotteita.</p>
                                </div>
                            </div>       
                        </div>
                        <img src="themes/img/sivut.jpg" class="img-responsive" alt="">
                    </div>
                    <div class="portfolio-caption">
                        <h4>Etsi</h4>
                        <p class="text-muted">Etsi tuotetta nimellä</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 portfolio-item">
                    <div class="portfolio-link">
                        <div class="reuna">
                            <div class="portfolio-hover-content" ng-controller="addProductController">
                                <div class="wella">
                                <h4>Lisää tai muokkaa tuotetta</h4>
                                <ng-form name="productForm">
                                <div class="input-fields">
                                    <!--label for="nimi">Nimi:-->
                                        <input ng-model="item.nimi"" name="nimi" ng-maxlength="100" class="input-line full-width" placeholder='Nimi' type="text" ng-required="true">
                                    <!--/label><br-->
                                    <ng-messages for="productForm.nimi.$error" class="text-danger">
                                        <ng-message when="required"> Nimi kenttä vaaditaan</ng-message>
                                        <ng-message when="maxlength">Nimi tulisi olla enintään 100 merkkiä pitkä</ng-message>
                                   </ng-messages><br>
                                    <!--label for="koko">Koko <span class="label-info-text">(pakkauksen koko)</span>:</label-->
                                    <input ng-model="item.koko" ng-maxlength="128" class="input-line full-width" placeholder='Koko'>
                                    <!--label for="valmistaja">Valmistaja:-->
                                        <input ng-model="item.valmistaja"" ng-maxlength="100" class="input-line full-width" placeholder='Valmistaja' type="text">
                                    <!--/label><br-->
                                    
                                    <button class="ghost-round full-width" ng-disabled="productForm.$invalid" ng-click="add()">
                                        Lisää
                                    </button>
                                    <button class="ghost-round full-width" ng-click="reset()">
                                        Tyhjennä
                                    </button>
                                </div>
                            </ng-form>
                        </div>

                            </div>
                        </div>
                        <img src="themes/img/valokuvaus.jpg" class="img-responsive" alt="">
                    </div>
                    <div class="portfolio-caption">
                        <h4>Lisää</h4>
                        <p class="text-muted">Lisää tai muokkaa tuotetta</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a class="portfolio-link">
                        <div class="reuna">
                            <div class="portfolio-hover-content">
                                <h4 class="service-heading">Tuotteiden etsiminen</h4>
                                <p class="text-muted">Kirjoita hakukenttään tuotten nimi tai alkukirjain. Hakutoiminto etsii kaikki vastaavat tuotteet listaan. 
                                </p>
                                <h4 class="service-heading"> Tuotteiden muokkaaminen</h4>
                                <p class="text-muted">Valitse tuote listasta klikkaamalla sitä. Kaikki tuotteen muokattavissa olevat arvot siirtyvät muokattaviksi lomakkeeseen. Muista painaa lisää, jotta arvot päivittyvät. </p>
                                <h4 class="service-heading">Uusi tuote</h4>
                                <p class="text-muted">Jos lomake kentässä on arvoja, tyhjennä lomake painamalla tyhjennä painiketta. Täytä vaaditut ja halutut arvot. Paina lopuksi lisää.</p>
                            </div>                   
                        </div>
                                        
                        <img src="themes/img/sovellukset.jpg" class="img-responsive" alt="">
                    </a>
                
                     <div class="portfolio-caption">
                        <h4>Ohjeet</h4>
                        <p class="text-muted">Etsi, lisää ja muokkaa</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


