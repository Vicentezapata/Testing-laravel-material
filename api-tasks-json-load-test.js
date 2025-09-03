import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  vus: 20, // usuarios virtuales simultáneos
  duration: '15s', // duración total de la prueba
};

export default function () {
  const res = http.get('http://testing-laravel-material.test/tasks-json');
  check(res, {
    'status is 200': (r) => r.status === 200,
    'response is array': (r) => Array.isArray(r.json()),
  });
  sleep(1);
}
