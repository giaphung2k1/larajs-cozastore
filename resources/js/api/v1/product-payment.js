/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:27:50
 * File: ProductPayment.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';
export default class ProductPaymentResource extends Resource {
  constructor() {
    super('/product-payments');
  }
  rollback(product){
    return request({
      url: this.uri + '/' + product.id + '/rollback',
      method: 'delete',
      data: product,
    });
  }

  // {{$API_NOT_DELETE_THIS_LINE$}}
}
