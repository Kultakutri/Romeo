<section id="portfolio" class="bg-light-gray">
    <div class="container">
        <div class="row">

                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Tuotteet</h2>
                </div>
            
                <div class="col-sm-6 col-md-4 portfolio-item">
                    <div class="portfolio-link">
                        <div class="reuna">
                            <div class="portfolio-hover-content">
                                <input class="input-line full-width" type="text" ng-model="filterText" placeholder="Etsi nimellä"></input>
                            </div>

                            <div class="col-lg-12 text-center" ng-controller="productsController">
                                <div class="oma green">
                                    <h4>Listan tuotteet:</h4>
                                    <div ng-if="items.length > 0">
                                        <ol class="tuotteet">
                                            <li ng-repeat="item in items | filter:filterText | orderBy: 'nimi' track by $index">
                                                <button class="portaat" ng-click="delItem(item.id, item.list_id)">{{item.nimi}}</button>
                                            </li>
                                        </ol>
                                    </div>
                                    <div ng-if="items.length < 1">
                                        <p>Ei tuotteita.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img src="themes/img/sivut.jpg" class="img-responsive" alt="">
                    </div>
                    <div class="portfolio-caption">
                        <h4>Listan tuotteet</h4>
                        <p class="text-muted">Etsi tuotetta nimellä</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 portfolio-item">
                    <div class="portfolio-link">
                        <div class="reuna">
                            <div class="portfolio-hover-content">
                                <input class="input-line full-width" type="text" ng-model="filterText2" placeholder="Etsi nimellä"></input>
                            </div>

                            <div ng-controller="allAddProductsController">
                            <div class="oma yellow">
                                <h4>Kaikki tuotteet:</h4>
                                <div ng-if="items.length > 0">
                                    <ol class="tuotteet">
                                        <li ng-repeat="item in items | filter:filterText2 | orderBy: 'nimi' track by $index">
                                            <button class="portaat" ng-click="addItem(item.id)">{{item.nimi}}</button>
                                        </li>
                                    </ol>
                                </div>
                            <div ng-if="items.length < 1">
                                <p>Ei tuotteita.</p>
                            </div>
                            </div>
                            </div>
                        </div>
                    <img src="themes/img/sivut.jpg" class="img-responsive" alt="">
                    </div>
                    <div class="portfolio-caption">
                        <h4>Kaikki tuotteet</h4>
                        <p class="text-muted">Etsi tuotetta nimellä</p>
                    </div>
                </div>

                        <!--ohjeet-->
                        <div class="col-sm-6 col-md-4 portfolio-item">
                            <a class="portfolio-link">
                                <div class="reuna">
                                    <div class="portfolio-hover-content">
                                        <h4 class="service-heading"> Tuotteiden etsiminen listasta ja kaikista tuotteista</h4>
                                        <p class="text-muted">Kirjoita hakukenttään tuotteen nimi tai alkukirjain. Hakutoiminto etsii kaikki vastaavat tuotteet listalta. 
                                        </p>
                                        <h4 class="service-heading"> Tuotteen poistaminen listalta</h4>
                                        <p class="text-muted">Poista tuote listasta klikkaamalla sitä.</p>
                                        <h4 class="service-heading">Tuotteen lisääminen listalle</h4>
                                        <p class="text-muted">Etsi tuote Kaikki tuotteet kohdasta ja paina haluamaasi tuotetta. Tuote monistuu omaan listaasi.</p>
                                    </div>                   
                                </div>
                                                
                                <img src="themes/img/sovellukset.jpg" class="img-responsive" alt="">
                            </a>
                        
                             <div class="portfolio-caption">
                                <h4>Ohjeet</h4>
                                <p class="text-muted"> Listan muokkaaminen</p>
                            </div>

                <!--/div-->
                            <div class="row"> <div class="col-sm-7"></div>
                        </div>

                            