import { beforeEach, describe, test, vi } from 'vitest';
import axios from 'axios';

const url = 'https://testprojectemma.strangled.net/cursos';
const url2 = 'https://testprojectemma.strangled.net/dashboard/recursos/add';


test('Obtenir cursos', async () => {
    try {
      const response = await axios.get(url);
  
      expect(response.status).toBe(200);
  
      expect(response.data).toBeDefined();
      expect(Array.isArray(response.data)).toBe(true);
    } catch (error) {
      console.error(error);
    }
  }
);

test('Crear recurso', async () => {
    try {
        const authResponse = await axios.post('https://testprojectemma.strangled.net/login', {
            username: 'emma@gmail.com',
            password: '123123123123'
          });
      
          const authToken = authResponse.data.token;
      
          const config = {
            headers: { Authorization: `Bearer ${authToken}` }
          };
      
          const response = await axios.post(url2, { }, config);
      
          expect(response.status).toBe(200);
          expect(response.data).toBeDefined();
        } catch (error) {
          console.error(error);
        }
      });