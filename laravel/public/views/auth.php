<div class="row" ng-controller="loginController">
    <div class="rivi">
        <div class='window'>
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Kirjaudu tai rekisteröidy</h2>
                </div>
                
                <div class="content" >
                    <ng-form name="loginForm" class="form-horizontal">
                        <div class="input-fields">
                            <!--label for="email" class="col-sm-3 control-label">Email</label-->
                            <div class="col-sm-12">
                                <input type="email" class="input-line full-width" id="email" name="email" placeholder="Sähköposti" required="true" ng-model="auth.email">
                            
                                <ng-messages for="loginForm.email.$error" class=" spacing">
                                    <ng-message when="email">Email ei kelpaa</ng-message>
                                    <ng-message when="required">Email puuttuu</ng-message>
                                </ng-messages>
                            </div>
                        </div>
                        <div class="input-fields">
                            <!--label for="inputPassword3" class="col-sm-3 control-label">Salasana</label-->
                            <div class="col-sm-12">
                                <input type="password" class="input-line full-width" id="password" name="password" placeholder="Password" required="true" ng-model="auth.password" minlength="6">
                                <ng-messages for="loginForm.password.$error" class=" spacing">
                                    <ng-message when="required">Salasana puuttuu</ng-message>
                                    <ng-message when="minlength">Liian lyhyt</ng-message>
                                </ng-messages>
                            </div>

                        </div>
                        
                        <div class="form-group last">
                            <div class="col-sm-12">
                                <button type="submit" class="btn ghost-round full-width btn-sm"  ng-disabled="loginForm.$invalid" ng-click="login()">Kirjaudu</button>
                                <!--button type="reset" class="btn btn-success btn-sm" class="btn btn-default btn-sm">Reset</button-->
                                <button type="submit" class="btn ghost-round full-width btn-sm"  ng-disabled="loginForm.$invalid" ng-click="register()">Rekisteröidy</button>
                            </div>
                        </div>
                    </ng-form>
                    <!--div ng-if="user">{{ user }}</div-->

            </div>
            </div>   
        </div>
    </div>