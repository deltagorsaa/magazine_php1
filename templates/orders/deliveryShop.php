<?php
$deliveryOfficeMin = date_add(date_create(), date_interval_create_from_date_string($deliveryOfficeDefault[0]['min_delivery_day'] . ' days'));
$deliveryOfficeMax = date_add(date_create(), date_interval_create_from_date_string($deliveryOfficeDefault[0]['max_delivery_day'] . ' days'));

if (empty($_GET['part'])):?>
<div class="shop-page__delivery shop-page__delivery--no">
    <table class="custom-table">
        <caption class="custom-table__title">Пункт самовывоза</caption>
        <tr>
            <td class="custom-table__head">Адрес:</td>
            <td class="order__sorting">
                <div class="order__delivery-offices__sorting-item custom-form__select-wrapper width-100">
                    <select class="custom-form__select" name="delivery_offices">
                        <?php foreach ($deliveryOffices as $deliveryOffice):?>
                            <option value="<?=$deliveryOffice['id']?>" <?=$deliveryOffice['id'] === $deliveryOfficeDefaultId ? 'selected' : ''?>>
                                <?=$deliveryOffice['country']?> г, <?=$deliveryOffice['city']?> ул, <?=$deliveryOffice['street'] . ' ' . $deliveryOffice['street_number'] . ($deliveryOffice['room'] ? ' - ' . $deliveryOffice['room'] : '')?>
                            </option>
                        <?php endforeach?>
                    </select>
                </div>
            </td>
        </tr>
<?php endif?>
        <tr class="shop-page__delivery__time-info">
            <td class="custom-table__head">Время работы:</td>
            <td>
                <?php foreach($daysInfo as $time => $days):?>
                    <div>
                        <?php $days = array_values(array_unique($days));
                        $flag = false;
                        for($i=0; $i < sizeof($days); $i++):?>
                            <?php if ((($days[$i+1] ?? -1) - 1 == $days[$i])):
                                if (!$flag){
                                    echo WEEK_DAYS[$days[$i] - 1][1] . ' - ';
                                    $flag = true;
                                }
                                ?> <?php else:
                                echo WEEK_DAYS[$days[$i] - 1][1] . (($i + 1 != sizeof($days)) ? ' , ' : '');
                                $flag = false;
                                ?> <?php endif?>
                        <?php endfor?>
                        , <?=$time?>
                    </div>
                <?php endforeach?>
            </td>
        </tr>
        <tr class="shop-page__delivery__payment-info">
            <td class="custom-table__head">Оплата:</td>
            <td>
                <?=implode(' или ',array_unique(array_column($deliveryOfficeDefault, 'payment_type')))?>
            </td>
        </tr>
        <tr class="shop-page__delivery__delivery-time-info">
            <td class="custom-table__head">Срок доставки: </td>
            <td class="date">
                <?=date_format($deliveryOfficeMin , 'd')  . ' ' . MONTH[date_format($deliveryOfficeMin , 'n') - 1][0] . MONTH[date_format($deliveryOfficeMin , 'n') - 1][1]?>
                -
                <?=date_format($deliveryOfficeMax , 'd')  . ' ' . MONTH[date_format($deliveryOfficeMax , 'n') - 1][0] . MONTH[date_format($deliveryOfficeMax , 'n') - 1][1]?>
            </td>
        </tr>
<?php if (empty($_GET['part'])):?>
    </table>
</div>
<?php endif?>

