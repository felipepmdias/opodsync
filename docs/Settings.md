
# Salvar Configurações (Save Settings)

**POST `/api/2/settings/(username)/(scope).json**`

* **Requer Autenticação**
* **Desde a versão 2.4**

### Exemplo de requisição:

```json
{
    "set": {"setting1": "value1", "setting2": "value2"},
    "remove": ["setting3", "setting4"]
}

```

* **`set`** é um dicionário de configurações para adicionar ou atualizar.
* **`remove`** é uma lista de chaves que devem ser removidas do escopo.

### Parâmetros:

* **`scope`** – um entre: `account` (conta), `device` (dispositivo), `podcast`, `episode` (episódio).

### Parâmetros de Consulta:

* **`podcast`** (*string*) – URL do feed de um podcast (obrigatório para os escopos `podcast` e `episode`).
* **`device`** – ID do dispositivo (veja Dispositivos, obrigatório para o escopo `device`).
* **`episode`** – URL de mídia do episódio (obrigatório para o escopo `episode`).

### Exemplo de resposta:

A resposta contém todas as configurações que o escopo possui após a atualização ter sido realizada.

---

# Obter Configurações (Get Settings)

**GET `/api/2/settings/(username)/(scope).json**`

* **Requer Autenticação**
* **Desde a versão 2.4**

### Parâmetros:

* **`scope`** – um entre: `account`, `device`, `podcast`, `episode`.

### Parâmetros de Consulta:

* **`podcast`** (*string*) – URL do feed de um podcast (obrigatório para os escopos `podcast` e `episode`).
* **`device`** – ID do dispositivo (veja Dispositivos, obrigatório para o escopo `device`).
* **`episode`** – URL de mídia do episódio (obrigatório para o escopo `episode`).

### Exemplo de resposta:

A resposta contém todas as configurações que o escopo possui atualmente:

```json
{
    "setting1": "value1",
    "setting2": "value2"
}

```
