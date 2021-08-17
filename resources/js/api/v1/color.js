/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:23:52
 * File: Color.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class ColorResource extends Resource {
  constructor() {
    super('/colors');
  }

  getColor() {
    return request({
      url: '/colors/get-colors',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
