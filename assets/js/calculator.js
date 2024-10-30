var icAmountLimits = {
    amountMin: 500000,
    amountMax: 10000000
}

function serializeObject(obj) {
    var serialized = [];
    for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
            serialized.push(encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]));
        }
    }
    return serialized.join('&');
};

function numberFormat(nStr)
{
    nStr += "";
    x = nStr.split(".");
    x1 = x[0];
    x2 = x.length > 1 ? "," + x[1] : "";
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, "$1" + " " + "$2");
    }
    return x1 + x2;
}

function displayLoanData(formData, response)
{
    document.getElementById("calculationId").value = response.calculationId;
    document.getElementById("offerId").value = response.offers[0].offerId;

    document.querySelector(".offer-logo img").src = response.offers[0].partnerLogo.replace("download", "public");
    document.querySelector(".offer-logo img").alt = response.offers[0].partnerName;
    document.querySelector(".offer-name").innerHTML = response.offers[0].offerName;
    document.querySelector(".offer-partner").innerHTML = response.offers[0].partnerName;
    document.querySelector(".offer-apr").innerHTML = numberFormat(response.offers[0].apr.toFixed(2))+"%";
    document.querySelector(".offer-repay").innerHTML = numberFormat(response.offers[0].monthlyPayment)+" Ft";
    document.querySelector(".offer-total").innerHTML = numberFormat(response.offers[0].totalPayment)+" Ft";
    document.querySelector(".offer-amount").innerHTML = numberFormat(formData.amount - formData.downPayment)+" Ft";
}

function displayErrors(error)
{
    document.querySelector(".offer-error .error").style.display = "none";
    document.querySelector(".offer-error .minAmount").style.display = "none";
    document.querySelector(".offer-error .downPayment").style.display = "none";

    if(error != null && typeof error == "string") {
        document.querySelector(".offer-error .error").innerText = error;
        document.querySelector(".offer-error .error").style.display = "block";
    } else if(error != null && typeof error == "object") {
        document.querySelector(".offer-error ." + error.wrapper).querySelector(".amount").innerText = error.amount;
        document.querySelector(".offer-error ." + error.wrapper).style.display = "block";
    }
}

function calculateLoanData(amount, downPayment)
{

    downPayment  = downPayment.value.replace(/\s+/g, "");
    var error    = null;
    var duration = document.querySelector('input[name="duration"]:checked').value;
    var formData = {
        amount: amount,
        duration: duration,
        downPayment: downPayment
    };

    if ( ( amount - downPayment ) < icAmountLimits.amountMin )
    {
        error = {
            wrapper: "downPayment",
            amount: numberFormat(Math.abs(Math.abs(icAmountLimits.amountMin - formData.amount)-downPayment))
        };
        formData.amount = (parseInt(icAmountLimits.amountMin) + parseInt(downPayment)).toString();

        if ( amount < icAmountLimits.amountMin )
        {
            error = {
                wrapper: "minAmount",
                amount: numberFormat(icAmountLimits.amountMin)
            };
            formData.amount = icAmountLimits.amountMin;
        }


    }

    displayErrors(error);
    XhrRequest(formData);
    return formData.amount;
}

function XhrRequest(formData) {
    document.getElementById("posOverlay").style.display = "block";
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == xhr.DONE && this.status == 200) {
            displayLoanData(formData, JSON.parse(this.responseText));
            document.getElementById("posOverlay").style.display = "none";
        }
        if (this.readyState == xhr.DONE && this.status == 503) {
            var response = JSON.parse(this.responseText);
            if (response.data.message) {
                displayErrors(response.data.message);
                document.getElementById("posOverlay").style.display = "none";
            }
        }
    };
    xhr.open("POST", POSObject.calculator, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(serializeObject(formData));
}

// document.body.addEventListener("change", function(e){
//     if (e.target && e.target.classList.contains("shipping_method")){
//         setTimeout( setAmounts, 500);
//     }
// });

document.addEventListener("keyup", function(e){
    if(e.target && e.target.id == "downPayment"){
        e.target.value = numberFormat(e.target.value.replace(/\s+/g, ""));
    }
});

document.addEventListener("change", function(e){
    if(e.target && e.target.id == "downPayment"){
        calculateLoanData(document.getElementById("totalAmount").value, document.getElementById("downPayment"));
    }
});

document.addEventListener("click", function(e){
    if(e.target && e.target.classList.contains("btn-check")){
        calculateLoanData(document.getElementById("totalAmount").value, document.getElementById("downPayment"));
    }
});

function setAmounts() {
    var amount      = document.getElementById("totalAmount").value;
    var downPayment = document.getElementById("downPayment");
    document.querySelector(".suff-amount-max").innerText = numberFormat((amount - icAmountLimits.amountMin) > 0 ? amount - icAmountLimits.amountMin : 0 );

    calculateLoanData(amount, downPayment);
}

// setTimeout( setAmounts, 1000);

jQuery( document.body ).on( 'updated_checkout', function(){
    setAmounts();
});
