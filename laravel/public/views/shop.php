<div class="row">
    <div class="col-lg-12 text-center">
        <h2 class="section-heading">Kaupat</h2>
        <!--h3 class="section-subheading text-muted black">Voit lisätä/poistaa kaupan omalle listallesi klikkaamalla lisää/poista. Lisää kaupalle lista kirjoittamalla sen nimi alla olevaan kenttään.</h3-->
    </div>
</div>

<section id="portfolio" class="bg-light-gray">
    <div class="container">
        <div class="row" ng-controller="shopController" ng-if="shop">

            <div class="col-sm-6 portfolio-item"  >
                 <div class="portfolio-link">
                    <div class="reuna">
                        <div class="portfolio-hover-content">
                            <div class="content">
                             
    <!--div class="row"-->
        <!--div class="col-md-4 col-sm-6 portfolio-item reuna">
            <div class="oma"-->
                                <h3>{{shop.shop}} </h3>  
                                <a class="ghost-round full-width" href="#/del_shop/{{shop.id}}" title="Poista kauppa omalta listalta">Poista</a>
                                    
                                <a class="ghost-round full-width" href="#/add_shop/{{shop.id}}" title="Lisää kauppa listalle">Lisää</a>
                                
                            </div>
                        </div>
                    </div>
                        <img src="themes/img/valokuvaus.jpg" class="img-responsive" alt="">
                    </div><!-- a-->
                    <div class="portfolio-caption">
                        <h4>Kauppa</h4>
                        <p class="text-muted">Lisää/poista kauppa listalta</p>
                    </div>
            </div>
    <!--/div-->
	<!--div class="row" ng-controller="addListController"-->
            <div class="col-sm-6 portfolio-item" ng-controller="addListController">
            <div class="portfolio-link">
               <div class="reuna">
                   <div class="portfolio-hover-content">
                        <div class="wella">
                            <h4>Lisää uusi lista</h4>
                            <ng-form name="listForm">
				                <div class="input-fields"> <!--class="form-group form-inline"-->
					               <!--label for="selite">Nimi: -->
						              <input ng-model="list.nimi"" ng-maxlength="100" class="input-line full-width" placeholder='Nimi' name="nimi" type="text" ng-required="true">
					               <!--/label--><!--br-->
                                    <ng-messages for="listForm.nimi.$error" class="text-danger">
                                    <ng-message when="required"> Nimi kenttä vaaditaan</ng-message>
                                    <ng-message when="maxlength">Nimi tulisi olla enintään 100 merkkiä pitkä</ng-message>
                                    </ng-messages>
					               <button class="ghost-round full-width" ng-disabled="listForm.$invalid" ng-click="add()">
						          Lisää
					               </button>
                                </div>
                            </ng-form>
                        </div>
                    </div>
                </div>
                <img src="themes/img/valokuvaus.jpg" class="img-responsive" alt="">
            </div>
            <div class="portfolio-caption">
                <h4>Lista</h4>
                <p class="text-muted">Lisää kaupalle uusi lista</p>
            </div>
            </div>
    <!--/div-->
    <!--div class="row" ng-controller="listaController"-->
            <div class="col-sm-6 portfolio-item" ng-controller="listaController">
            <div class="portfolio-link">
               <div class="reuna">
                   <div class="portfolio-hover-content">
                        <div class="wella">
                            <h4>Listat</h4>
                            <ng-form name="listdetailForm">
                                <div class='input-fields' ng-if="listas.length > 0">
                                    <ol class="no_margin laatikko">
                                        <li ng-repeat="list in listas track by $index">
                                            <input class="input-line full-width" ng-maxlength="100" ng-model="list.nimi" name="nimi" type="text" ng-required="true">
                                        <ng-messages for="listdetailForm.nimi.$error" class="text-danger">
                                            <ng-message when="required"> Nimi kenttä vaaditaan</ng-message>
                                            <ng-message when="maxlength">Nimi tulisi olla enintään 100 merkkiä pitkä</ng-message>
                                        </ng-messages>
                                        <div ng-if="list.created_at" data-target="list.id">
                                            <span>
                                                <button class="ghost-round full-width" ng-click="updateItem(list.nimi, list.id)">Nimeä</button>
                                                <a href="" ng-if="list.created_at">
                                                    <span class="glyphicon glyphicon-chevron-down" data-target=#{{list.id}} data-toggle="collapse" data-toggle="tooltip" title="Näytä luontipäivä" ></span>
                                                </a>
                                                <a href="#/show-items/{{list.id}}">
                                                    <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Muokkaa listaa"></span>
                                                </a>
                                                <a href="#/del_list/{{list.id}}">
                                                    <span class="glyphicon glyphicon-remove-circle" data-toggle="tooltip" title="Poista lista"></span>
                                                </a>
                                            </span>
                                            <div ng-if="list.created_at" id={{list.id}} class="collapse">
                                            <div>{{list.created_at}}</div>
                                        </div>
                                        </li>
                                    </ol>
                                </div>
                            </ng-form>
                            <div ng-if="listas.length < 1">
                                <p>Sinulla ei ole vielä listoja.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <img src="themes/img/sivut.jpg" class="img-responsive" alt="">
            </div>
            <div class="portfolio-caption">
                <h4>Listat</h4>
                <p class="text-muted">Näytä/muokkaa/poista lista</p>
            </div>
            </div>
            <!--ohjeet-->
            <div class="col-sm-6 portfolio-item">
                <a class="portfolio-link">
                    <div class="reuna">
                        <div class="portfolio-hover-content">
                            <h4 class="service-heading">Oma lista</h4>
                            <p class="text-muted">Voit kerätä omia kauppoja omalle listalle. Omat listasi näkyy valikossa Listat kohdassa. Listat tarkoittaa siis oikeastaan kauppoja, joilla on listoja ja näillä listoilla on tuotteita. 
                            </p>
                            <h4 class="service-heading">Kaupan lisääminen ja poistaminen omalta listalta</h4>
                            <p class="text-muted">Kaupan nimen vieressä on lisää ja poista linkki. Kun kaupan nimeä ei näy listat-kohdan alasvetovalikossa, silloin kauppa ei ole vielä omalla listallasi. Tällöin voit painaa lisää, joilloin kauppa siirtyy valikkoon. Huomaa valikon etsi toiminto, jolla voit etsiä nimen mukaan kauppaa. Alasvetovalikko on rullattava, vain kaksi tulosta näkyy kerrallaan.
                            </p>
                            <p class="text-muted">Jos haluat poistaa kaupan omalta listalta paina kaupan nimen vieressä olevaa poista linkkiä. 
                            </p>
                            <h4 class="service-heading"> Lisää kaupalle uusi lista</h4>
                            <p class="text-muted">Valitse listalle nimi ja paina lisää. Lista siirtyy listat kohtaan, jossa pääset muokkaamaan listan nimeä, ja lisäämään/poistamaan listalle tuotteita tai poistamaan listan.</p>
                            <h4 class="service-heading">Listat</h4>
                            <p class="text-muted">Listat kohdasta pääset katsomaan, muokkaamaan ja poistamaan listan. </p>
                             <h5 class="service-heading">Listan nimeäminen uudelleen 
                             </h5><p> Listan nimeä voi vaihtaa kirjoittamalla tekstikenttään uuden nimen ja painamalla nimeä.</p>
                              <h5 class="service-heading">Tuotteiden lisääminen listalle ja listan muokkaaminen 
                             </h5><p> Painamalla kynä ikonia pääset lisäämään uusia tuotteita listalle tai poistamaan niitä.</p>
                              <h5 class="service-heading">Listan poistaminen 
                             </h5><p> Listan voi poistaa painamalla raksi ikonia.</p>
                        </div>                    
                    </div>
                                    
                    <img src="themes/img/sovellukset.jpg" class="img-responsive" alt="">
                </a>
            
                 <div class="portfolio-caption">
                    <h4>Ohjeet</h4>
                    <p class="text-muted">Kaupan ja listojen hallinta</p>
                </div>

    <!--/div-->
    <div class="row"> <div class="col-sm-7"></div>
</div>
<div ng-if="!shop">
    Kauppaa ei löytynyt.
</div>
</div>
</div>
</section>