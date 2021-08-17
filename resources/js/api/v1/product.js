/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:13:07
 * File: Product.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class ProductResource extends Resource {
  constructor() {
    super('/products');
  }

  getProduct() {
    return request({
      url: '/products/get-products',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
