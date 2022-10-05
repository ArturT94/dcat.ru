function isEmptyString(value)
  {return ('' + value).trim().length == 0;       
  }
function propertiesAreEmptyString(keys)
  {var result = undefined;
   for(var index = 0; index < arguments.length; index++)
     {if(!isEmptyString(this[arguments[index]]))
        {result = false;              
        }
      if(result !== undefined)
        {break;              
        }
     }
   if(result === undefined)
     {result = true;              
     }
   return result;
  }
jQuery.prototype.fill = function(value)
  {if(isEmptyString(value))
     {this.css('display', 'none');        
     }
   else
     {this.text('' + value);
      this.css('display', 'revert');        
     }
  }
getData = (guid) => {
    $.ajax({
        url: "/local/ajax/form/ajaxForm.php",
        method: "post",
        dataType: "json",
        data: "param=" + JSON.stringify(guid),
        success: function (res) {
            function getPriceHTML() {
                if (!arguments.callee.hasOwnProperty('formatter')) {
                    arguments.callee.formatter = new Intl.NumberFormat();
                }
                return arguments.callee.formatter.format.apply(arguments.callee.formatter, arguments);
            }
function intToWords(int, names) {
	var result = [];
	if (typeof int === 'number') {
		int = int.toString();
	} else if (typeof int !== 'string') {
		int = '';
	}
	if (!(names instanceof Array) || (typeof names[0] !== 'string') || (typeof names[1] !== 'string') || (typeof names[2] !== 'string')) {
		names = null;
	}
	if (int.length && !/[^0-9]/.test(int)) {
		var selectName = function (number, names) {
			return names[((parseInt(number) % 100 > 4) && (parseInt(number) % 100 < 20)) ? 2 : [2, 0, 1, 1, 1, 2][Math.min(parseInt(number) % 10, 5)]];
		};
		var name = null;
		var zero = 'ноль';
		if (int === '0') {
			result.push(zero);
		} else {
			var from0To2 = [zero, 'одна', 'две'];
			var from0To19 = [
				zero, 'один', 'два', 'три', 'четыре',
				'пять', 'шесть', 'семь', 'восемь', 'девять',
				'десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать',
				'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'
			];
			var tens = [
				'десять', 'двадцать', 'тридцать', 'сорок', 'пятьдесят',
				'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'
			];
			var hundreds = [
				'сто', 'двести', 'триста', 'четыреста', 'пятьсот',
				'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'
			];
			var thousands = [
				['тысяча', 'тысячи', 'тысяч'],
				['миллион', 'миллиона', 'миллионов'],
				['миллиард', 'миллиарда', 'миллиардов'],
				['триллион', 'триллиона', 'триллионов'],
				['квадриллион', 'квадриллиона', 'квадриллионов'],
				['квинтиллион', 'квинтиллиона', 'квинтиллионов'],
				['секстиллион', 'секстиллиона', 'секстиллионов'],
				['септиллион', 'септиллиона', 'септиллионов'],
				['октиллион', 'октиллиона', 'октиллионов'],
				['нониллион', 'нониллиона', 'нониллионов'],
				['дециллион', 'дециллиона', 'дециллионов']
			];
			var unknown = '{неизвестно}';
			var numberParts = int.replace(/(?=(\d{3})+(?!\d))/g, ' ').split(' ');
			var i = numberParts.length - 1;
			for (var j in numberParts) {
				var numberPart = parseInt(numberParts[j]);
				if (numberPart) {
					var numberPartResult = [];
					var hundred = Math.floor(numberPart / 100);
					if (hundred) {
						numberPartResult.push(hundreds[hundred - 1]);
						numberPart -= hundred * 100;
					}
					if (numberPart > 19) {
						var ten = Math.floor(numberPart / 10);
						numberPartResult.push(tens[ten - 1]);
						numberPart -= ten * 10;
					}
					if (numberPart) {
						numberPartResult.push(((i === 1) && ([1, 2].indexOf(numberPart) !== -1)) ? from0To2[numberPart] : from0To19[numberPart]);
					}
					if (thousands[i - 1] !== undefined) {
						numberPartResult.push(selectName(numberParts[j], thousands[i - 1]));
					} else if (i !== 0) {
						numberPartResult.push(unknown);
					} else if (names) {
						name = selectName(numberParts[j], names);
					}
					result.push(numberPartResult.join(' '));
				}
				i--;
			}
			if (!result.length) {
				result.push(zero);
			}
		}
		if (!name && names) {
			name = selectName(0, names);
		}
		if (name) {
			result.push(name);
		}
	}
	return result.join(' ');
}
   String.prototype.ucfirst = function()
     {return this.substring(0, 1).toUpperCase() + this.substring(1);
     }
           
   function nof(numberof, value, suffix)
     {// не будем склонять отрицательные числа
      numberof = Math.abs(numberof);
      var keys = [2, 0, 1, 1, 1, 2];
      var mod = numberof % 100;
      var suffix_key = (mod > 4 && mod < 20) ? 2 : keys[Math.min(mod % 10, 5)];
      return value + suffix[suffix_key];
     }

            if (res) {
                jQuery('#article').parents('.acts__details').eq(0)[propertiesAreEmptyString.call(res[0], 'articleProduct', 'seriaNumber', 'Product') ? 'hide' : 'show']();                     
                jQuery('#orderData').parents('.acts__details').eq(0)[propertiesAreEmptyString.call(res[0], 'typeOfWork', 'orderStatus', 'deliveryAdress') ? 'hide' : 'show']();                     
                jQuery('#company').parents('.acts__line').eq(0)[propertiesAreEmptyString.call(res[2], 'PROPERTY_PROP11_VALUE', 'PROPERTY_PROP12_VALUE', 'PROPERTY_MANAGER_PHONE') ? 'hide' : 'show']();                     
                jQuery("#article").fill(res[0].articleProduct);
                jQuery("#seriaNumber").fill(res[0].seriaNumber);
                jQuery("#Product").fill(res[0].Product);
                jQuery("#orderData").fill(res[0].orderData);
                jQuery("#orderNumber").fill(res[0].orderNumber);
                // jQuery("#orderStatus").fill(res[0].orderStatus);
                // jQuery("#typeOfWork").fill(res[0].typeOfWork);
                jQuery("#deliveryAdress").fill(res[0].deliveryAdress);
                jQuery("#company").fill(res[3].PROPERTY_NAME_VALUE);
                jQuery("#adress_company").fill(res[2].PROPERTY_PROP8_VALUE);
                jQuery("#inn").fill(res[3].PROPERTY_INN_VALUE);
                jQuery("#kpp").fill(res[3].PROPERTY_KPP_VALUE);
                jQuery("#email_manager_company").fill(res[3].PROPERTY_MANAGER_EMAIL_VALUE);
                jQuery("#name_manager_company").fill(res[3].PROPERTY_MANAGER_NAME_VALUE);
                // jQuery("#phone_company2").fill(res[3].PROPERTY_MANAGER_PHONE_VALUE);
                jQuery("#phone_company").fill(res[3].PROPERTY_MANAGER_PHONE_VALUE);
                // jQuery(".car__name").text(res.name);
                // jQuery(".car__model").text(res.gosNumber);
                // jQuery("#year").text(res.year);
                // jQuery("#probeg").text(res.probeg);
                // jQuery("#osago").text(res.osago);
                // jQuery("#wheels").text(res.wheels);
                // jQuery("#vin").text(res.vin);
                // getExternalCar = res.externalId;
                // markaMenu = res.marka;
                // modelMenu = res.model;
                console.log(res)
                var MATCHES = ['work', 'product'], ITEMS = new Object(), MATCHES_STAYED = MATCHES, sumCount = [], sum = 0;
                for (var index = 0; index < res.length; index++) {
                    var element = res[index];
                    if ((typeof element == 'object') && (element !== null)) {
                        MATCHES_STAYED = MATCHES_STAYED.filter(function (match) {
                            var found, key, match;
                            if (found = (element.hasOwnProperty(key = [match, 'Items'].join('')))) {
                                ITEMS[match] = element[key];
                                for(let pr in ITEMS.product){
                                    sumCount.push(+ITEMS.product[pr].PROPERTY_PRICE_VALUE);
                                }
                                for(let wr in ITEMS.work){
                                    sumCount.push(+ITEMS.work[wr].PROPERTY_PRICE_VALUE);
console.log(sumCount);
                                }
                            }
                            return !found;
                        });
                        if (MATCHES_STAYED.length == 0) {
                            break;
                        }
                    }
                }
                                sumCount = sumCount.flat(Infinity);
                                for (let i = 0; i < sumCount.length; i++){
                                    sum += sumCount[i];
                                }
                var $ELEMENTS = jQuery('html > body > #popup > .container > .container_second > div.tables'),
                    TR_TEMPLATE_ELEMENT = document.createElement('tr');
                TR_TEMPLATE_ELEMENT.classList.add('tables__line', 'box-shadow');
                TR_TEMPLATE_ELEMENT.innerHTML = `<td class="tables__column">
                                <div class="tables__wrap">
                                    <img class="tables__img" src="/local/templates/dcut/assets/img/form/service.svg" alt="">
                                    <div class="tables__wrapper">
                                        <p class="tables__text">Ремонт инструмента</p>
                                        <div class="tables__content">
                                            <div class="tables__price">
                                                <p class="tables__price__text">Кол-во: <span class="tables__price__span">1</span></p>
                                                <p class="tables__price__text">Ед. <span class="tables__price__span">шт</span></p>
                                                <p class="tables__price__text">Цена: <span class="tables__price__span">1,145.00</span></p>
                                            </div>
                                            <p class="tables__price__word">Сумма: <span class="tables__price__cost">1,145.00</span></p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="tables__column tables__column_none">1</td>
                            <td class="tables__column tables__column_none box-shadow">шт.</td>
                            <td class="tables__column tables__column_none box-shadow">1,145.00</td>
                            <td class="tables__column tables__column_none box-shadow">1,145.00</td>`;
                let countOfNames = 0, sumAsValue = 0;
                for (var index = 0; index < MATCHES.length; index++) {
                    var ELEMENT = $ELEMENTS.get(index), match = MATCHES[index], sum = [];
                    if (ITEMS.hasOwnProperty(match)) {
                        var CURRENT_ITEMS = ITEMS[match];
                        ELEMENT.style.display = 'revert';
                        ELEMENT = ELEMENT.querySelector(':scope > .tables__table');
                        ELEMENT.querySelectorAll(':scope > tbody > tr:not(:nth-child(1)), :scope > tr:not(:nth-child(1))').forEach(function (element) {
                            element.remove();
                        });
                        for (var indexOfTheItem = 0; indexOfTheItem < CURRENT_ITEMS.length; indexOfTheItem++) {
                            var THIS_TR = TR_TEMPLATE_ELEMENT.cloneNode(true), item = CURRENT_ITEMS[indexOfTheItem];
                            THIS_TR.querySelector(':scope > td:nth-child(1) .tables__text').innerHTML = item.PROPERTY_FULLNAME_VALUE;
                            THIS_TR.querySelector(':scope > td:nth-child(2)').innerHTML = item.PROPERTY_QUANTITY_VALUE;
                            THIS_TR.querySelector(':scope > td:nth-child(4)').innerHTML = getPriceHTML(item.PROPERTY_PRICE_VALUE)+' руб.';
                            THIS_TR.querySelector(':scope > td:nth-child(5)').innerHTML = getPriceHTML(item.PROPERTY_SUM_VALUE)+' руб.';
                            ELEMENT.appendChild(THIS_TR);
                            sumAsValue += (+ item.PROPERTY_SUM_VALUE);
                            sum.push(+item.PROPERTY_PRICE_VALUE);
                        }
                      countOfNames += CURRENT_ITEMS.length;

                    } else {
                        ELEMENT.style.display = 'none';
                    }
                }
              var totalPriceAsHTML = getPriceHTML(sumAsValue), totalPriceAsString = intToWords(Math.floor(sumAsValue), ['рубль', 'рубля', 'рублей']), fractionalPart, TAX_MULTIPLIER = 0.2;
              if((fractionalPart = sumAsValue - Math.floor(sumAsValue)) != 0)
                {totalPriceAsString += ', ' + intToWords(Math.round(fractionalPart * 100), ['копейка', 'копейки', 'копеек']);
                }
              totalPriceAsString = totalPriceAsString.ucfirst();
              jQuery('.results__text').html(`<span class="results__text_bold">Всего наименований ${countOfNames},</span> на
                                сумму <span>${totalPriceAsHTML}</span> руб.`);
              /*jQuery('.results__total > div:nth-child(2) .results__total__text').html('Сумма НДС (' + (TAX_MULTIPLIER * 100) + '%):');
              */
              jQuery('.results__total > div:nth-child(2) .results__total__span').html(getPriceHTML((sumAsValue * TAX_MULTIPLIER).toFixed(2)));
              jQuery('.results__total > div:nth-child(1) .results__total__span, .results__total > div:nth-child(3) .results__total__span:nth-child(2)').html(totalPriceAsHTML+' руб.');
              jQuery('.results__total > div:nth-child(2) .results__total__span').html(getPriceHTML(sumAsValue * 0.2)+' руб.');
              jQuery('.results__content > .results__text_bold').html(totalPriceAsString);
            } else {
                console.err("Произошла ошибка");
            }
        },
    });
};