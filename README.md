#<p align="center">Cypto Platform</p>

## #1 Feature
Filtering and real time updating of data (APY)

## Filters
- Token Type
- Pair Type
- Investment Type
- Protocol
- Tokens (AND & OR via radio buttons)
- Free text

## Notes for filters
- Show time when the data was synced
- Custom rounding of TVL value
    ```
    < 100: Round to 2 decimals
    >= 100 & < 20,000: Round to nearest decimal
    >= 20,000 & <100,000,000: Round to nearest thousand
    >= 100,000,000 & <100,000,000,000: Round to nearest million
    >= 100,000,000,000: Round to nearest billion
    ```
- APY and TVL filter by greater/lesser amounts
    ```
    1bn +
    100m to 1bn
    10m to 100m
    1m to 10m
    100k to 1m
    10k. to 100k
    below 10k
    ```
- User can choose between APY or APR (other value should be greyed out)
- User can choose token pair type
- 
