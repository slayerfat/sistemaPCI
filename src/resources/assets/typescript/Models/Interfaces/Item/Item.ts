/// <reference path="ItemType.ts"/>
/// <reference path="../Maker/Maker.ts"/>
/// <reference path="../Stock/Stock.ts"/>

module Models.Interfaces
{
    import ItemType = Models.Interfaces.ItemType;
    import Maker  = Models.Interfaces.Maker.Maker;
    import Stock  = Models.Interfaces.Stock.Stock;

    export interface Item
    {
        id: number;
        desc: string;
        slug: string;
        quantity: number;
        stock_type_id: number;
        type: ItemType;
        maker: Maker;
        stocks: Array<Stock>;
    }
}
