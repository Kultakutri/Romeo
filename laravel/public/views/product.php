<div>
     <input type="text" ng-model="filterText" placeholder="Etsi tuote nimellä"></input>
</div>

<div class="row" ng-controller="allProductsController">
    <div class="col-sm-12">
        <div class="oma">
            <h4>Kaikki tuotteet:</h4>
            <div ng-if="items.length > 0">
                <ol class="flex-container wrap">
                    <li class="flex-itemHome yellow" ng-repeat="item in items | filter:filterText | orderBy: 'nimi' track by $index" title="Muokkaa tuotetta">
                        <a href="#/add_product/{{item.id}}">
                            {{item.nimi}} 
                        </a>
                        </button>
                    </li>
                </ol>
            </div>
            <div ng-if="items.length < 1">
                <p>Ei tuotteita.</p>
            </div>
        </div>
    </div>
</div>
<div class="row" ng-controller="addProductController">
        <div class="col-lg-12">
            <div class="wella">
                <h4>Lisää tai muokkaa tuotetta</h4>
                <ng-form name="productForm">
                <div class="form-group form-inline">
                    <label for="nimi">Nimi:
                        <input ng-model="item.nimi"" name="nimi" ng-maxlength="100" class="form-control" type="text" ng-required="true">
                    </label><br>
                    <ng-messages for="productForm.nimi.$error" class="text-danger">
                        <ng-message when="required"> Nimi kenttä vaaditaan</ng-message>
                        <ng-message when="maxlength">Nimi tulisi olla enintään 100 merkkiä pitkä</ng-message>
                   </ng-messages>
                    <label for="koko">Koko <span class="label-info-text">(pakkauksen koko)</span>:</label>
                    <input ng-model="item.koko" ng-maxlength="128" class="form-control" style="width:80px;">
                    <label for="valmistaja">Valmistaja:
                        <input ng-model="item.valmistaja"" ng-maxlength="100" class="form-control" type="text">
                    </label><br>
                    
                    <button class="btn" ng-disabled="productForm.$invalid" ng-click="add()">
                        Lisää
                    </button>
                    <button class="btn" ng-click="reset()">
                        Tyhjennä
                    </button>
                </div>
                <ng-form>
                <!--/div-->
            </div>
        </div>
    </div>