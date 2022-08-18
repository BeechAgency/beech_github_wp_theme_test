
// Get rate
// Multply cost and hours (via rate type)
// Watch for new rows

// Add it all together to the cost field

// Watch cost field and times that to propsal (if auto-calc is true)
const BeechCalculator = {};
BeechCalculator.rates = {};

BeechCalculator.auto = true;
BeechCalculator.margin = 50;
BeechCalculator.proposed = 0;
BeechCalculator.cost = 0;

console.log('Calcuator Init');

(function() {
    // Handle the stuff.
    if(typeof acf !== 'object') return console.warn('No ACF: No Calculator');

    console.log('Object is acf!');

    document.addEventListener('DOMContentLoaded', () => {
        console.log('Setting up!');

        acf.addAction('load', function(){

            setUpBeechRates();
            setUpBasicFields();

            setUpItems();

            // Do this whenever a dude gets added
            acf.addAction('append', function( $el ) {
                const el_items =  document.querySelector('[data-name="items"]');
                const key_items = el_items.dataset.key;
                const field_items = acf.getField(key_items);
                const total_items = field_items.val();

                console.log(total_items);

                setUpItemRow( el_items, total_items - 1 );

                $el.find('.my-element').hide();
            });

        });
    });
})();


function setUpItems() {

    console.log('Setting items!');

    const el_items =  document.querySelector('[data-name="items"]');
    const key_items = el_items.dataset.key;
    const field_items = acf.getField(key_items);
    const total_items = field_items.val();

    console.log('item_length', total_items);

    for(var i = 0; i < total_items; i++ ) {
        //console.log('Setting item iterator!');
        setUpItemRow(el_items, i);
    }

}

function setUpItemRow(el_items, i) {
    console.log('Setting setUpItemRow!');
    //const item_row = el_items.querySelector('[data-id="row-'+i+'"]');
    const row_number = Number(i)+1;

    const item_row = el_items.querySelector('.acf-table tbody tr:nth-child('+row_number+')');

    //console.log('Row: ', i+1, item_row, '.acf-table tbody tr:nth-child('+row_number+')');

    const item_hours = item_row.querySelector('[data-name="hours"] input');
    const item_type = item_row.querySelector('[data-name="type"] select');
    const item_cost = item_row.querySelector('[data-name="cost"] input');

    //console.log('item Row setup!', item_row, item_hours, item_type);

    item_hours.addEventListener('input', function(e) {
        const new_hours = Number(e.target.value);

        const type_value = item_type.value.toLocaleLowerCase().replace(' ', '_');
        const rate = BeechCalculator.rates[type_value];

        item_cost.value = new_hours * Number(rate);
        item_cost.dispatchEvent(new Event('input'));

        return;
    });


    item_type.addEventListener('change', function(e) {
        const new_value = e.target.value;
        const new_type_value = new_value.toLocaleLowerCase().replace(' ', '_');

        item_cost.value = Number(item_hours.value) * Number(BeechCalculator.rates[new_type_value]);
        item_cost.dispatchEvent(new Event('input'));

        return;
    });
    

    item_cost.addEventListener('input', function(e) {
        //console.log('Change!');
        const el_costs = document.querySelectorAll('.item_cost input');

        const costs_arr = [];
        const reducer = (accumulator, curr) => accumulator + curr;

        el_costs.forEach( item => {
            const value = Number(item.value);

            if(isNaN(value)) return;

            costs_arr.push(value);
        });

        const cost = costs_arr.reduce(reducer);

        BeechCalculator.cost = cost;


        const key_cost = document.querySelector('[data-name="cost"]').dataset.key;
        const input_cost = document.querySelector('[data-name="cost"] input');
        const field_cost = acf.getField(key_cost);

        input_cost.dispatchEvent(new Event('change'));

        field_cost.trigger('input', [cost]);
        field_cost.val(cost);
    });


    return;
}


function setUpBasicFields() {
    console.log('Setting setUpBasicFields!');

    const key_proposed = document.querySelector('[data-name="proposed"]').dataset.key;
    const key_margin = document.querySelector('[data-name="margin"]').dataset.key;
    const key_cost = document.querySelector('[data-name="cost"]').dataset.key;
    const key_auto = document.querySelector('[data-name="auto"]').dataset.key;

    const field_proposed = acf.getField(key_proposed);
    const field_margin = acf.getField(key_margin);
    const field_cost = acf.getField(key_cost);
    const field_auto = acf.getField(key_auto);

    BeechCalculator.proposed = field_proposed.val();
    BeechCalculator.cost = field_cost.val();
    BeechCalculator.margin = field_margin.val();

    function inputHandler(event, new_value) {
        //console.log(event);

        let value = event.target.value;
        const currentTarget = event.currentTarget;
        const name = currentTarget.dataset.name;


        //console.log(value, currentTarget, name);

        if(BeechCalculator.auto !== true) return;

        if(name === 'cost') {
            if(value === undefined) {
                value = new_value;
            }
        }

        //console.log(value, currentTarget, name);

        BeechCalculator[name] = Number(value);
        //console.log(name);

        field_margin.val(BeechCalculator.margin);
        field_cost.val(BeechCalculator.cost);
        
        field_proposed.val(  BeechCalculator.cost / (BeechCalculator.margin / 100) ); 
        
    }

    field_proposed.on('input', inputHandler);
    field_margin.on('input', inputHandler);
    field_cost.on('input', inputHandler);

    field_auto.on('change', function(e) {
        BeechCalculator.auto = e.target.checked;
    });
}

function setUpBeechRates() {
    console.log('Setting setUpBeechRates!');
    
    // Setup Rates and monitor them.
    const rate_items = ['design', 'digital', 'development', 'project_management', 'strategy', 'comms', 'printing', 'video', 'photography'];

    rate_items.forEach( item => {
        //console.log(item);
        const el_item = document.querySelector('[data-name="rate_'+item+'"]');

        if(!el_item) {
            console.log('No ', item);
            return;
        }

        const key_item = el_item.dataset.key;
        const field_item =  acf.getField(key_item);

        BeechCalculator.rates[item] = Number(field_item.val());

        // Add an event listener to update on change.
        field_item.on('input', function(e) {
            const value = e.target.value;

            //console.log(e.currentTarget.dataset, e.target.dataset);

            BeechCalculator.rates[item] = Number(value);

            return;
        })
    });

    return;
}