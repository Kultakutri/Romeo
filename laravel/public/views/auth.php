<div class="row" ng-controller="loginController">
        <div class="col-sm-12">
            <div class="wella">
                <div class="panel-heading"> <strong class="">Kirjaudu tai rekisteröidy</strong>
 
                </div>
                <div class="panel-body" >
                    <ng-form name="loginForm" class="form-horizontal">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Sähköposti" required="true" ng-model="auth.email">
                            
                                <ng-messages for="loginForm.email.$error" class="text-danger">
                                    <ng-message when="email">Email ei kelpaa</ng-message>
                                    <ng-message when="required">Email puuttuu</ng-message>
                                </ng-messages>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Salasana</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="true" ng-model="auth.password" minlength="6">
                                <ng-messages for="loginForm.password.$error" class="text-danger">
                                    <ng-message when="required">Salasana puuttuu</ng-message>
                                    <ng-message when="minlength">Liian lyhyt</ng-message>
                                </ng-messages>
                            </div>

                        </div>
                        
                        <div class="form-group last">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success btn-sm"  ng-disabled="loginForm.$invalid" ng-click="login()">Kirjaudu</button>
                                <!--button type="reset" class="btn btn-default btn-sm">Reset</button-->
                                <button type="submit" class="btn btn-success btn-sm"  ng-disabled="loginForm.$invalid" ng-click="register()">Rekisteröidy</button>
                            </div>
                        </div>
                    </ng-form>
                    <!--div ng-if="user">{{ user }}</div-->
                </div>
            </div>
        </div>
    </div>