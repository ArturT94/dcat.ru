<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if($arResult["SHOW_SMS_FIELD"] == true) {
	CJSCore::Init('phone_auth');
}
global $USER;
$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), array('ID'=>$USER->GetId()),array('SELECT'=>array('UF_*')));
while($arUser = $rsUsers->Fetch()){
    $arCurUser = $arUser;
}
if($arCurUser['UF_GUID']){
    $arSelect = Array("ID", "NAME", "PROPERTY_*");
    $arFilter = Array("IBLOCK_ID"=>13, "PROPERTY_GUID"=>$arCurUser['UF_GUID'], "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while($ob = $res->Fetch()) {
        $arCurLk = $ob;
    }
    if(!$arCurLk){
        LocalRedirect('/personal/');
    }
}else{
    LocalRedirect('/personal/');
}

?>
<ul class="profile-tabs_group">
    <li class="profile-tab active">Персональные данные</li>
    <?/*li class="profile-tab">Уведомления</li*/?>
</ul>

<div class="bx-auth-profile">
<?ShowError($arResult["strProfileError"]);?>
<?if ($arResult['DATA_SAVED'] == 'Y') ShowNote(GetMessage('PROFILE_DATA_SAVED'));?>
<?if($arResult["SHOW_SMS_FIELD"] == true):?>
    <form method="post" action="<?=$arResult["FORM_TARGET"]?>">
        <?=$arResult["BX_SESSION_CHECK"]?>
        <input type="hidden" name="lang" value="<?=LANG?>" />
        <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
        <input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>" />
        <table class="profile-table data-table">
            <tbody>
                <tr>
                    <td><?echo GetMessage("main_profile_code")?><span class="starrequired">*</span></td>
                    <td><input size="30" type="text" name="SMS_CODE" value="<?=htmlspecialcharsbx($arResult["SMS_CODE"])?>" autocomplete="off" /></td>
                </tr>
            </tbody>
        </table>
        <p><input type="submit" name="code_submit_button" value="<?echo GetMessage("main_profile_send")?>" /></p>
    </form>
    <script>
        new BX.PhoneAuth({
            containerId: 'bx_profile_resend',
            errorContainerId: 'bx_profile_error',
            interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
            data:
                <?=CUtil::PhpToJSObject([
                    'signedData' => $arResult["SIGNED_DATA"],
                ])?>,
            onError:
                function(response){
                    var errorDiv = BX('bx_profile_error');
                    var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
                    errorNode.innerHTML = '';
                    for(var i = 0; i < response.errors.length; i++)
                    {
                        errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
                    }
                    errorDiv.style.display = '';
                }
        });
    </script>
    <div id="bx_profile_error" style="display:none"><?ShowError("error")?></div>
    <div id="bx_profile_resend"></div>
<?else:?>
    <script type="text/javascript">
        var opened_sections = [<?
        $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
        $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
        if ($arResult["opened"] <> '')
        {
            echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
        }
        else
        {
            $arResult["opened"] = "reg";
            echo "'reg'";
        }
        ?>];
        var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
    </script>
    <form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
        <?=$arResult["BX_SESSION_CHECK"]?>
        <input type="hidden" name="lang" value="<?=LANG?>" />
        <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

            <div class="profile-content_group settigs-content-group">
                <div class="profile-content">
                    <div class="content-block settings-content-block">
                        <div class="content-block_title">
                            <span>Логин и пароль</span>
                            <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                        </div>
                        <div class="content-block_hidden">
                            <div class="content-hidden_row">
                                <div class="content-hidden_column">
                                    <form action="" class="settings-form">
                                        <label for="email" class="settings-form_title">E-mail</label>
                                        <div class="settings-form_elements">
                                            <input id="email" disabled class="settings-input" type="text" value="<?=$arCurUser['EMAIL']?>">
                                            <?/*button class="settings-button" id="email-one" onclick="enableInput('email')">
                                                <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                            </button>
                                            <button class="settings-button settings-button-ok" id="email-two" onclick="change('email')">ОК</button*/?>
                                        </div>
                                    </form>
                                    <?/*div class="add-element">+ Добавить E-mail адрес</div*/?>
                                </div>

                                <div class="content-hidden_column">
                                    <form action="" class="settings-form">
                                        <label for="phone-1" class="settings-form_title">Телефон</label>
                                        <div class="settings-form_elements">
                                            <input id="phone-1" disabled class="settings-input" value="<?=$arCurLk['']?>" type="tel">
                                            <?/*button class="settings-button" id="phone-1-one" onclick="enableInput('phone-1')">
                                                <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                            </button>
                                            <button class="settings-button settings-button-ok" id="phone-1-two" onclick="change('phone-1')">ОК</button*/?>
                                        </div>
                                    </form>

                                    <?/*form action="" class="settings-form">
                                        <div class="settings-form_elements">
                                            <input id="phone-2" disabled class="settings-input" type="tel" placeholder="+79685270002">
                                            <button class="settings-button" id="phone-2-one" onclick="enableInput('phone-2')">
                                                <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                            </button>
                                            <button class="settings-button settings-button-ok" id="phone-2-two" onclick="change('phone-2')">ОК</button>
                                        </div>
                                    </form*/?>
                                    <?/*div class="add-element">+ Добавить телефон</div*/?>
                                </div>
                                <div class="content-hidden_column">
                                    <?/*form action="" class="settings-form">
                                        <label for="password-1" class="settings-form_title">Пароль</label>
                                        <div class="settings-form_elements elements-password">
                                            <img id="password01-vis" onclick="passVis('password01')" class="password-vis" src="/local/templates/dcut/assets/img/profile-settings/eye.svg" alt="img">
                                            <img id="password01-hid" onclick="passHid('password01')" src="/local/templates/dcut/assets/img/profile-settings/not-eye.svg" alt="img" class="password-hid">
                                            <input id="password01" class="settings-input settings-input-password" type="pasword" placeholder="Текущий пароль">
                                        </div>
                                    </form*/?>
                                    <form action="" class="settings-form">
                                        <div class="settings-form_elements elements-password">
                                            <img id="password02-vis" onclick="passVis('password02')" class="password-vis" src="/local/templates/dcut/assets/img/profile-settings/eye.svg" alt="img">
                                            <img id="password02-hid" onclick="passHid('password02')" src="/local/templates/dcut/assets/img/profile-settings/not-eye.svg" alt="img" class="password-hid">
                                            <input id="password02" name="NEW_PASSWORD" class="settings-input settings-input-password" type="password" placeholder="Новый пароль">
                                        </div>
                                    </form>
                                    <form action="" class="settings-form">
                                        <div class="settings-form_elements elements-password">
                                            <img id="password03-vis" onclick="passVis('password03')" class="password-vis" src="/local/templates/dcut/assets/img/profile-settings/eye.svg" alt="img">
                                            <img id="password03-hid" onclick="passHid('password03')" src="/local/templates/dcut/assets/img/profile-settings/not-eye.svg" alt="img" class="password-hid">
                                            <input id="password03" name="NEW_PASSWORD_CONFIRM" class="settings-input settings-input-password" type="password" placeholder="Подтвердите новый пароль">
                                        </div>
                                    </form>
                                    <?/*a href="#" class="add-element">+ Изменить пароль</a*/?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                    $name = explode(' ',$arCurLk['PROPERTY_51']);
                    ?>
                    <div class="content-block settings-content-block"> <!-- Контактные данные представителя компании -->
                        <div class="content-block_title">
                            <span>Контактные данные представителя компании</span>
                            <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                        </div>
                        <div class="content-block_hidden">
                            <div class="content-hidden_row">
                                <div class="content-hidden_column"> <!-- Фамилия -->
                                    <form action="" class="settings-form">
                                        <label for="surname" class="settings-form_title">Фамилия</label>
                                        <div class="settings-form_elements">
                                            <input id="surname" disabled class="settings-input" type="text" value="<?=$name[0]?>">
                                            <?/*button class="settings-button" id="surname-one" onclick="enableInput('surname')">
                                                <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                            </button>
                                            <button class="settings-button settings-button-ok" id="surname-two" onclick="change('surname')">ОК</button*/?>
                                        </div>
                                    </form>
                                </div>

                                <div class="content-hidden_column"> <!-- Имя -->
                                    <form action="" class="settings-form">
                                        <label for="name" class="settings-form_title">Имя</label>
                                        <div class="settings-form_elements">
                                            <input id="name" disabled class="settings-input" type="tel" value="<?=$name[1]?>">
                                            <?/*button class="settings-button" id="name-one" onclick="enableInput('name')">
                                                <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                            </button>
                                            <button class="settings-button settings-button-ok" id="name-two" onclick="change('name')">ОК</button*/?>
                                        </div>
                                    </form>
                                </div>

                                <div class="content-hidden_column"> <!-- Отчество -->
                                    <form action="" class="settings-form">
                                        <label for="patronymic" class="settings-form_title">Отчество</label>
                                        <div class="settings-form_elements">
                                            <input id="patronymic" disabled class="settings-input" type="tel" value="<?=$name[2]?>">
                                            <?/*button class="settings-button" id="patronymic-one" onclick="enableInput('patronymic')">
                                                <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                            </button>
                                            <button class="settings-button settings-button-ok" id="patronymic-two" onclick="change('patronymic')">ОК</button*/?>
                                        </div>
                                    </form>
                                </div>

                                <div class="content-hidden_column"> <!-- Должность -->
                                    <form action="" class="settings-form">
                                        <label for="prof" class="settings-form_title">Должность</label>
                                        <div class="settings-form_elements">
                                            <input id="prof" class="settings-input settings-input-password" type="text" value="<?=$arCurLk['PROPERTY_52']?>">
                                        </div>
                                    </form>
                                </div>
                                <?
                                if($arCurLk['PROPERTY_53']){
                                    $date = explode('T',$arCurLk['PROPERTY_53']);
                                    $date2 = explode('-',$date[0]);
                                }
                                ?>
                                <?/*div class="content-hidden_column"> <!-- ДР -->
                                    <form action="" class="settings-form">
                                        <label for="prof" class="settings-form_title">День рождения</label>
                                        <div class="birthday">
                                            <div class="select birthday-select">
                                                <input id="prof" class="settings-input settings-input-password" disabled type="text" value="<?=$date2[2]?>">
                                            </div>
                                            <div class="select birthday-select">
                                                <input id="prof" class="settings-input settings-input-password" disabled type="text" value="<?=$date2[1]?>">
                                            </div>
                                            <div class="select birthday-select">
                                                <input id="prof" class="settings-input settings-input-password" disabled type="text" value="<?=$date2[0]?>">
                                            </div>
                                        </div>
                                    </form>
                                </div*/?>
                                <?/*div class="content-hidden_column"> <!-- Пол -->
                                    <form action="" class="settings-form">
                                        <div class="settings-form_title">Пол</div>
                                        <div class="settings-form-flex">
                                            <label class="settings-form-radio-label"  for="man">
                                                <input class="settings-form-radio-input" id="man" type="radio" name="framework">
                                                <span class="settings-form-radio-title" >Мужской</span>
                                            </label>
                                            <label class="settings-form-radio-label"  for="woman">
                                                <input class="settings-form-radio-input" id="woman" type="radio" name="framework">
                                                <span class="settings-form-radio-title" >Женский</span>
                                            </label>
                                        </div>
                                    </form>
                                </div*/?>
                            </div>
                        </div>
                    </div>

                    <div class="content-block settings-content-block"> <!-- Информация о компании -->
                        <div class="content-block_title">
                            <span>Информация о компании</span>
                            <svg width="11" height="7" class="icon"><use xlink:href="#angle-right"></use></svg>
                        </div>
                        <div class="content-block_hidden">

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- Полное наименование компании -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="company" class="settings-form_title">Полное наименование компании</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="company" disabled class="settings-input settings-input-flex" type="text" value="<?=$arCurLk['PROPERTY_50']?>">
                                        <?/*button class="settings-button" id="company-one" onclick="enableInput('company')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="company-two" onclick="change('company')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- Сфера деятельности -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="defectiveness" class="settings-form_title">Сфера деятельности</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="work" disabled disabled class="settings-input settings-input-flex" type="text">
                                        <?/*button class="settings-button" id="work-one" onclick="enableInput('work')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="work-two" onclick="change('work')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"><!-- Размер компании / количество сотрудников -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="size" class="settings-form_title">Размер компании / количество сотрудников</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="size" disabled class="settings-input settings-input-flex" type="text">
                                        <?/*button class="settings-button" id="size-one" onclick="enableInput('size')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="size-two" onclick="change('size')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- Юридический адрес -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="address" class="settings-form_title">Юридический адрес</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="address" disabled class="settings-input settings-input-flex" type="text" value="<?=$arCurLk['PROPERTY_56']?>">
                                        <?/*button class="settings-button" id="address-one" onclick="enableInput('address')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="address-two" onclick="change('address')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- Почтовый индекс -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="address" class="settings-form_title">Почтовый индекс</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="index" disabled class="settings-input settings-input-flex" type="text" placeholder="<?=$arCurLk['PROPERTY_57']?>">
                                        <?/*button class="settings-button" id="index-one" onclick="enableInput('index')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="index-two" onclick="change('index')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- Сайт -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="site" class="settings-form_title">Сайт</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="site" disabled class="settings-input settings-input-flex" type="text" value="<?=$arCurLk['PROPERTY_58']?>">
                                        <?/*button class="settings-button" id="site-one" onclick="enableInput('site')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="site-two" onclick="change('site')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- ИНН -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="inn" class="settings-form_title">ИНН</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="inn" disabled class="settings-input settings-input-flex" type="text" value="<?=$arCurLk['PROPERTY_59']?>">
                                        <?/*button class="settings-button" id="inn-one" onclick="enableInput('inn')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="inn-two" onclick="change('inn')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- ОГРН -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="orgn" class="settings-form_title">ОГРН</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="orgn" disabled class="settings-input settings-input-flex" type="text" value="<?=$arCurLk['PROPERTY_61']?>">
                                        <?/*button class="settings-button" id="orgn-one" onclick="enableInput('orgn')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="orgn-two" onclick="change('orgn')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- БИК -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="bic" class="settings-form_title">БИК</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="bic" disabled class="settings-input settings-input-flex" type="text" value="<?=$arCurLk['PROPERTY_62']?>">
                                        <?/*button class="settings-button" id="bic-one" onclick="enableInput('bic')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="bic-two" onclick="change('bic')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- Расчётный счёт -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="score" class="settings-form_title">Расчётный счёт</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="score" disabled class="settings-input settings-input-flex" type="text" value="<?=$arCurLk['PROPERTY_63']?>">
                                        <?/*button class="settings-button" id="score-one" onclick="enableInput('score')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="score-two" onclick="change('score')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>

                            <div class="content-hidden_row content-hidden-row-flex"> <!-- КПП -->
                                <div class="content-hidden_column-flex-one">
                                    <label for="kpp" class="settings-form_title">КПП</label>
                                </div>
                                <div class="content-hidden_column-flex-two">
                                    <div class="settings-form_elements">
                                        <input id="kpp" disabled class="settings-input settings-input-flex" type="text" value="<?=$arCurLk['PROPERTY_60']?>">
                                        <?/*button class="settings-button" id="kpp-one" onclick="enableInput('kpp')">
                                            <svg width="22" height="22" class="icon"><use xlink:href="#pencil"></use></svg>
                                        </button>
                                        <button class="settings-button settings-button-ok" id="kpp-two" onclick="change('kpp')">ОК</button*/?>
                                    </div>
                                </div>
                            </div>
                            <?/*div class="privacyPolicy">
                                <label for="one"><input checked type="checkbox" id="one" name="todo" value="todo"> </span></label>
                                <div class="privacyPolicy-link">С <a href="#">Политикой обработки конфиденциальных данных</a>, а также <a href="#">Условиями сотрудничества с компанией DCUT</a> ознакомлен и согласен.</div>
                            </div*/?>
                        </div>
                    </div>
                </div>

                <?/*div class="profile-content"> <!-- Уведомления -->
                    <div class="content-block">
                        <div class="notification-row">
                            <div class="notification-column-one">
                                <div class="notification-title">Выберите, какие рассылки и по какому каналу связи получать</div>
                            </div>
                            <div class="notification-column-two title-name">
                                <div class="notification-sub-column"><div class="notification-title">SMS</div></div>
                                <div class="notification-sub-column"><div class="notification-title">E-mail</div></div>
                            </div>
                        </div>

                        <div class="notification-row">
                            <div class="notification-column-one">
                                <div class="notification-name">Акции компании и сезонные предложения</div>
                            </div>
                            <div class="notification-column-two">
                                <div class="notification-sub-column"><div class="notification-choise"><label for="null"><input type="checkbox" id="null" name="todo" value="todo"><span>SMS</span></label></div></div>
                                <div class="notification-sub-column"><div class="notification-choise"><label for="two"><input type="checkbox" id="two" name="todo" value="todo"><span>E-mail</span></label></div></div>
                            </div>
                        </div>

                        <div class="notification-row">
                            <div class="notification-column-one">
                                <div class="notification-name">Напоминание о незаконченном оформлении заказа</div>
                            </div>
                            <div class="notification-column-two">
                                <div class="notification-sub-column"><div class="notification-choise"><label for="three"><input type="checkbox" id="three" name="todo" value="todo"><span>SMS</span></label></div></div>
                                <div class="notification-sub-column"><div class="notification-choise"><label for="four"><input type="checkbox" id="four" name="todo" value="todo"><span>E-mail</span></label></div></div>
                            </div>
                        </div>

                        <div class="notification-row">
                            <div class="notification-column-one">
                                <div class="notification-name">Персональные рекомендации и скидки</div>
                            </div>
                            <div class="notification-column-two">
                                <div class="notification-sub-column"><div class="notification-choise"><label for="five"><input type="checkbox" id="five" name="todo" value="todo"><span>SMS</span></label></div></div>
                                <div class="notification-sub-column"><div class="notification-choise"><label for="six"><input type="checkbox" id="six" name="todo" value="todo"><span>E-mail</span></label></div></div>
                            </div>
                        </div>

                        <div class="notification-row">
                            <div class="notification-column-one">
                                <div class="notification-name">Окончание остатка по кредитному лимиту</div>
                            </div>
                            <div class="notification-column-two">
                                <div class="notification-sub-column"><div class="notification-choise"><label for="seven"><input type="checkbox" id="seven" name="todo" value="todo"><span>SMS</span></label></div></div>
                                <div class="notification-sub-column"><div class="notification-choise"><label for="eight"><input type="checkbox" id="eight" name="todo" value="todo"><span>E-mail</span></label></div></div>
                            </div>
                        </div>
                    </div>
                </div*/?>
            </div>
            <div class="settings-big-buttons">
                <button class="settings-cancel">Отмена</button>
                <button class="settings-save dark-button" type="submit" name="save"><span>Сохранить изменения</span></button>
            </div>

</form>
<?endif?>
</div>