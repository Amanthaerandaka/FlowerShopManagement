
const checkoutBtn = document.createElement('checkoutBtn')
console.log('LOG')

// checkoutBtn.addEventListener('click', () => {handleSubmit()})
const handleSubmit = async() => {
    console.log('Log')
    const key = 'pk_test_51MUkP2SBGImHqPo8Us2IfkFqeHA1VA2C3d2TszofioPvVwAQBbaGErBul7KMsAG0JWyfYbGnhjwT2l8VvpGpdynM00bXwUKPdK';
    const res = await fetch('http://localhost:5000/api/checkout/getStripe',{
        method: 'POST',
        headers : {
            'Content-Type': 'application/json',
        },
        body : JSON.stringify({'key' : key})
    })

    const response = await res.json();
    console.log(response)
    const stripe = response.StripePromise;


    const apiRes = await fetch('http://localhost:5000/api/checkout/paystripe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })

    const data = await apiRes.json()
    console.log(data)
    // return stripe.redirectToCheckout({sessionId: data.id})
}