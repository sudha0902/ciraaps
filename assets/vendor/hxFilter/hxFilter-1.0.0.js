/*
 * hxFilter.js (v1.2.0)
 *
 * This jQuery utility was developed by Bill Hicks
 * Copyright 2015 Media 1, Inc. solutions@media1.us
 *
 * Dependencies:
 *     jQuery      (v1.11.3+)
 * 
 */
(function ($) {
    "use strict";
    if(typeof Array.contains === "undefined" && typeof Array.unique === "undefined"){
        Array.prototype.contains = function(v) {
            for(var i = 0; i < this.length; i++) {
                if(this[i] === v) return true;
            }
            return false;
        };
        
        Array.prototype.unique = function() {
            var arr = [];
            for(var i = 0; i < this.length; i++) {
                if(!arr.contains(this[i])) {
                    arr.push(this[i]);
                }
            }
            return arr; 
        };
    }
    var getTime
    
    var _private = {  
        defaults: {
            value: "",
            style: ""
        },
        data: [],
        filters: {
            checkboxes: [],
            dropdowns: [],
            minmax: [],
            dateranges: []
        },
        setData: function(data, callback){
            this.data = data;
            this.callback = callback;
        },
        setActions: function(){
          // Need to clear the defaults or everything following will inherit it
          this.defaults = {
              value: "",
              style: ""
          };
          
          var $this = this;
          
          $("form.hxFilter").unbind("change");
          
          $("form.hxFilter").on("change", function(){
              $this.filter($this);
          });  
          // this.filter(this); // inital render
        },
        checkbox: function( options, element ){
            var opts = $.extend(this.defaults, options);
            
            if(this.data.length === 0){ 
                console.error("No data found!");
                return;
            }
            
            if(opts.value === ""){ 
                console.error("No value found!");
                return;
            }
            var list = [],
                emptyField = false;
            
            this.data.forEach(function(item, index, array){
                
                list.push(item[opts.value]);
                
            });
            
            list = list.unique();
            
            if(typeof list[0] === "undefined"){
                console.error("Value '" + opts.value + "' not in list!");
                return;
            }
            
            // Build filter in the designated selector
            var frm = $("<form>", { class: "hxFilter", "data-val": opts.value }).appendTo(element);
            list.forEach(function(val, index, array){
                var label = $("<label>", {
                    class: opts.style
                }).appendTo(frm);
                
                $("<input>",{
                    type: "checkbox",
                    value: val,
                    checked: true
                }).appendTo(label);  
                
                label.append(" " + val);                
            });
            
            
            this.filters.checkboxes.push(frm[0]);
            if(typeof opts.init === "function"){
                opts.init(frm[0]);    
            }
            this.setActions();
                
        },
        dropdown: function( options, element ){
            var opts = $.extend(this.defaults, options);
            
            if(this.data.length === 0){ 
                console.error("No data found!");
                return;
            }
            
            if(opts.value === ""){ 
                console.error("No value found!");
                return;
            }
            
            var list = [];
            this.data.forEach(function(item, index, array){
                list.push(item[opts.value]);
            });
            
            // list = $.unique(list);
            list = list.unique();
            
            if(typeof list[0] === "undefined"){
                console.error("Value '" + opts.value + "' not in list!");
                return;
            }
            
            //Build filter in the designated selector
            var frm = $("<form>", { class: "hxFilter", "data-val": opts.value }).appendTo(element),
                select = $("<select>", {
                    class: opts.style
                }).appendTo(frm); 
            
            if(opts.showAll){
                $("<option>",{
                    text:  "All",
                    value: "All"
                }).appendTo(select);
            }
                
            list.forEach(function(val, index, array){                
                $("<option>",{
                    text: val,
                    value: val
                }).appendTo(select);                    
            });
            
            this.filters.dropdowns.push(frm[0]);
            if(typeof opts.init === "function"){
                opts.init(frm[0]);   
            }
            this.setActions();
        },
        minmax: function( options, element ){
            var opts = $.extend(this.defaults, options);
            
            if(this.data.length === 0){ 
                console.error("No data found!");
                return;
            }
            
            if(opts.value === ""){ 
                console.error("No value found!");
                return;
            }
            var list = [];
            this.data.forEach(function(item, index, array){
                list.push(item[opts.value]);
            });
            
            //list = $.unique(list);
            list = list.unique();
            /* 121215 - modified/correct the sort function to perform a sort for min and max */
           	list =  list.sort(function(a, b){return a-b});
            
            if(typeof list[0] === "undefined"){
                console.error("Value '" + opts.value + "' not in list!");
                return;
            }
            
            //Build filter in the designated selector
            var frm = $("<form>", { class: "hxFilter", "data-val": opts.value }).appendTo(element),
                min = $("<label>", { 
                    text: "Minimum"
                }).appendTo(frm),
                max = $("<label>", {
                    text: "Maximum"
                }).appendTo(frm);
            
            console.dir(list);
            
            $("<input>", {
                type: "text",
                class: "hxFMin " + opts.style, 
                value: list[0]
            }).appendTo(min); 
            
            $("<input>", {
                type: "text",
                class: "hxFMax " + opts.style, 
                value: list.slice(-1)[0]
            }).appendTo(max); 
                
            this.filters.minmax.push(frm[0]);
            if(typeof opts.init === "function"){
                opts.init(frm[0]);   
            }
            
            this.setActions();
            
        },
        daterange: function( options, element ){
            // This filter requires daterangepicker.js from:
            // http://www.daterangepicker.com/
            // (daterangepicker.js requires: Bootstrap, jQuery, and Moment.js)
            if(typeof $().daterangepicker != "function"){
                console.error("The Date Range filter requires daterangepicker.js");
                return;
            }
            
            var opts = $.extend(this.defaults, options);
            
            if(this.data.length === 0){ 
                console.error("No data found!");
                return;
            }
            
            if(opts.value === ""){ 
                console.error("No value found!");
                return;
            }
            
            
            var list = [];
            this.data.forEach(function(item, index, array){
                var d = new Date(item[opts.value]),
                    sortObject = {
                        string: item[opts.value],
                        posix: d.getTime(),
                        local: d.get
                    };
                list.push(sortObject);
            });
            list.sort( function( a, b ){ return a.posix - b.posix } );
            // console.dir( list );
            
            var dateFrom = list[0],
                dateTo   = list.slice(-1)[0],
                initialRange = dateFrom.string + " - " + dateTo.string;
            
            //Build filter in the designated selector
            var frm = $("<form>", { class: "hxFilter", "data-val": opts.value }).appendTo(element);

                $("<input>", {
                    type: "text",
                    value: initialRange,
                    class: opts.style
                }).appendTo(frm); 
            
            $(frm[0][0]).daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                startDate: dateFrom.string,
                endDate: dateTo.string
            });         
            
            this.filters.dateranges.push(frm[0]);
            if(typeof opts.init === "function"){
                opts.init(frm[0]);   
            }
            this.setActions();
        },
        filter: function(){
            var app = this,
                fdata = this.data;
            
        // Exclusive filters
            // Dropdowns
            app.filters.dropdowns.forEach(function(input, index, array){
                var $key = $(input).data("val"),
                    $value = input[0].value;
                    
                if($value !== "All"){
                    fdata = $.grep(fdata, function(itm){
                        // console.log(itm[$key] + " " + $value + " [" + (itm[$key] === $value) + "]");
                        return (itm[$key] === $value);
                    });                    
                }
                
            });
            
            // Date Range
            app.filters.dateranges.forEach(function(input, index, array){
                var idata = [],
                    $key = $(input).data("val"),
                    $value = input[0].value,
                    dateFrom = moment($value.split(" - ")[0]).subtract(1, 'days'),
                    dateTo   = moment($value.split(" - ")[1]).add(1, 'days');
                      
                fdata = $.grep(fdata, function(itm){
                    var dateTest = moment(itm[$key]);
                   //sudha 02/19/16 return (dateTest.isBetween(dateFrom.subtract(1, 'days'), dateTo.add(1, 'days')));                    
                    return (dateTest.isBetween(dateFrom, dateTo));   //sudha 02/19/16                 
                    
                });                     
                    
            });  
            
            // Min Max
            app.filters.minmax.forEach(function(input, index, array){
                var idata = [],
                    $key = $(input).data("val"),
                    $min = parseInt(input[0].value),
                    $max = parseInt(input[1].value);
                    
                    if(isNaN($min) || isNaN($max)){
                        console.error("Both values must be numbers.");
                        return;
                    }
                    
                    if($min > $max){
                        console.error("The maximum value cannot be less than the minimum value");
                        input[0].value = $max;
                    }
                    
                fdata = $.grep(fdata, function(itm){
                    var $age = parseInt(itm[$key]);
                    return ($min <= $age && $age <= $max);
                });                     
                    
            });    
            
            // Inclusive Filters
            app.filters.checkboxes.forEach(function(input, index, array){
                var idata = [],
                    $key = $(input).data("val");
                    
                for(var box = 0; box < input.length; box++){
                    var $value = input[box].value;
                    if(input[box].checked){
                        var f = $.grep(fdata, function(itm){
                                    return (itm[$key] === $value);
                                });
                        idata = idata.concat(f);
                    }
                }
                // idata = $.unique(idata);
                idata = idata.unique();
                fdata = idata;
            });
            
            app.callback(fdata);
        }        
    }
    
    
    $.fn.hxData = function( data, callback ){
        _private.setData( data, callback );
    }
    
    $.fn.hxCheckbox = function( options ){
        _private.checkbox( options, this );
    }
    
    $.fn.hxDropdown = function( options ){
        _private.dropdown( options, this );
    }
    
    $.fn.hxMinMax = function( options ){
        _private.minmax( options, this );
    }
    
    $.fn.hxDaterange = function( options ){
        _private.daterange( options, this );
    }
    
    $.fn.hxRun = function(){
        _private.filter();
    }
    
}(jQuery));