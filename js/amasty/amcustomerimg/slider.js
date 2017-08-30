/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Customerimg
*/

var amSlider = new Class.create();

amSlider.prototype = {
    initialize: function(wrapId, options)
    {
        this.position   = 0;
        this.total      = options.total;
        this.itemWidth  = options.width;
        this.itemHeight = options.height;
        this.visibleCnt = options.visibleCnt;
        this.scrollCnt  = this.visibleCnt;
        this.self       = options.object;
        this.autoscroll = options.autoscroll;
        this.interval   = options.interval;
        
        
        $$('.' + wrapId + ' .box-amcustomerimg-slider-left').each(function(left){
            left.observe('click', this.scrollRight.bind(this));
        }.bind(this));
        
        $$('.' + wrapId + ' .box-amcustomerimg-slider-right').each(function(left){
            left.observe('click', this.scrollLeft.bind(this));
        }.bind(this));
        
        $$('.' + wrapId + ' ul').each(function(list){
            this.list = list;
        }.bind(this));
        
        $(wrapId).observe('mouseover', function(){
            this.autoScrollStop();
        }.bind(this));
        
        $(wrapId).observe('mouseout', function(){
            this.autoScrollStart();
        }.bind(this));
        
        this.autoScrollStart();
    },
    
    autoScrollStart: function()
    {
        if (this.autoscroll)
        {
            this.intervalHandler = setInterval(this.self + ".scrollLeft()", this.interval * 1000);
        }
    },
    
    autoScrollStop: function()
    {
        if (this.intervalHandler)
        {
            window.clearInterval(this.intervalHandler);
        }
    },
    
    scrollLeft: function()
    {
        if (this.position >= this.total - this.scrollCnt)
        {
            this.position = 0;
            new Effect.Move(this.list, { x: 0, mode: 'absolute' });
        } else 
        {
            this.position += this.scrollCnt;
            new Effect.Move(this.list, { x: -this.getScrollSize(), mode: 'relative' });
        }
    },
    
    scrollRight: function()
    {
        if (this.position <= 0)
        {
            this.position = this.scrollCnt * Math.round(this.total / this.visibleCnt);
            if (this.position == this.total)
            {
                this.position -= this.visibleCnt;
            }
            new Effect.Move(this.list, { x: -this.getScrollSize() * Math.round(this.position / this.scrollCnt) , mode: 'absolute' });
        } else 
        {
            this.position -= this.scrollCnt;
            new Effect.Move(this.list, { x: this.getScrollSize(), mode: 'relative' });
        }
    },
    
    getScrollSize: function()
    {
        return this.itemWidth * this.scrollCnt;
    }
};