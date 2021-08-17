/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 10:51:27
 * File: Category.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class CategoryResource extends Resource {
  constructor() {
    super('/categories');
  }

  getCategory() {
    return request({
      url: '/categories/get-categories',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
