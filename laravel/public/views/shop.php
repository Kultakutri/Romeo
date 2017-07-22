<div ng-if="shop" ng-controller="shopController">
    <div class="row">
        <div class="col-sm-12">
            <div class="oma">
                <h3>{{shop.shop}}
                <small><a href="#/del_shop/{{shop.id}}" title="Poista kauppa omalta listalta">Poista</a></small>
                <small><a href="#/add_shop/{{shop.id}}" title="Lisää kauppa listalle">Lisää</a></small></h3>
            </div>
        </div>
    </div>
	<div class="row" ng-controller="addListController">
        <div class="col-lg-12">
            <div class="wella">
                <h4>Lisää uusi lista</h4>
                <ng-form name="listForm">
				<div class="form-group form-inline">
					<label for="selite">Nimi:
						<input ng-model="list.nimi"" ng-maxlength="100" class="form-control" name="nimi" type="text" ng-required="true">
					</label><br>
                    <ng-messages for="listForm.nimi.$error" class="text-danger">
                        <ng-message when="required"> Nimi kenttä vaaditaan</ng-message>
                        <ng-message when="maxlength">Nimi tulisi olla enintään 100 merkkiä pitkä</ng-message>
                   </ng-messages>
					<button class="btn" ng-disabled="listForm.$invalid" ng-click="add()">
						Lisää
					</button>
                </div>
                </ng-form>
            </div>
        </div>
    </div>
    <div class="row" ng-controller="listaController">
        <div class="col-lg-12">
            <div class="wella">
                 <h4>Listat</h4>
                 <ng-form name="listdetailForm">
                <div ng-if="listas.length > 0">
                <ol class="no_margin">
                    <li ng-repeat="list in listas track by $index">
                    <input class="form-control" ng-maxlength="100" ng-model="list.nimi" name="nimi" type="text" ng-required="true">
                    <ng-messages for="listdetailForm.nimi.$error" class="text-danger">
                        <ng-message when="required"> Nimi kenttä vaaditaan</ng-message>
                        <ng-message when="maxlength">Nimi tulisi olla enintään 100 merkkiä pitkä</ng-message>
                   </ng-messages>
                    <div ng-if="list.created_at" data-target="list.id">
                    <span>
                        <button ng-click="updateItem(list.nimi, list.id)">Muuta</button>
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
    <div class="row"> <div class="col-sm-7"></div>
</div>
<div ng-if="!shop">
    Kauppaa ei löytynyt.
</div>