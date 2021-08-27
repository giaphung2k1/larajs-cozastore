/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-19 17:43:10
 * File: ProductDetail.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class ProductDetailResource extends Resource {
  constructor() {
    super('/product-details');
  }

  getProductDetail() {
    return request({
      url: '/product-details/get-product-details',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
