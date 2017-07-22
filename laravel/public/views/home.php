<div class="row">
	<div class="col-sm-12">
		<div class="oma" ng-if="!userMaybeLoggedIn">
            <!--div class="well" id="user"-->
            <div class="circle yellow">
            <h3 id="myName">Romeo </h3>
            <a href="#/signin">Kirjaudu sisään</a>
            </div>
            <div class="circle right tomato">
            </div>
            <div class="circle bottom green">
            </div>
        </div>
	</div>
</div>
<div class="row" ng-controller="shopsController" ng-if="userMaybeLoggedIn">
    <div class="col-sm-12">
        <div class="oma" id="top5">
            <h4>Kaikki kaupat:</h4>
            <div ng-if="shops.length > 0">
                <ol class="flex-container wrap">
                    <li class="flex-itemHome tomato" ng-repeat="shop in shops track by $index" title="Katso kaupan listoja">
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
</div>