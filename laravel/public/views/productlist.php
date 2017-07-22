    <div>
     <input type="text" ng-model="filterText" placeholder="Etsi nimellä"></input>
    </div>

    <div class="row" ng-controller="productsController">
        <div class="col-sm-12">
            <div class="oma green">
                <h4>Listan tuotteet:</h4>
                <div ng-if="items.length > 0">
                    <ol>
                        <li ng-repeat="item in items | filter:filterText | orderBy: 'nimi' track by $index">
                            <button ng-click="delItem(item.id, item.list_id)">{{item.nimi}}</button>
                        </li>
                    </ol>
                </div>
                <div ng-if="items.length < 1">
                    <p>Ei tuotteita.</p>
                </div>
            </div>
        </div>
    </div>

    <div>
     <input type="text" ng-model="filterText2" placeholder="Etsi nimellä"></input>
    </div>

    <div class="row" ng-controller="allAddProductsController">
        <div class="col-sm-12">
            <div class="oma yellow">
                <h4>Kaikki tuotteet:</h4>
                <div ng-if="items.length > 0">
                    <ol>
                        <li ng-repeat="item in items | filter:filterText2 | orderBy: 'nimi' track by $index">
                            <button ng-click="addItem(item.id)">{{item.nimi}}</button>
                        </li>
                    </ol>
                </div>
                <div ng-if="items.length < 1">
                    <p>Ei tuotteita.</p>
                </div>
            </div>
        </div>
    </div>