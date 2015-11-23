/// <reference path="StockDetails.ts"/>

module Models.Interfaces.Stock
{
    import StockDetails = Models.Interfaces.Stock.StockDetails;

    export interface Stock
    {
        details: Array<StockDetails>
    }
}
