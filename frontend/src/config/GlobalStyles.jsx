import { Global } from '@emotion/react'

const GlobalStyles = () => (
    <Global
        styles={{
            body: {
                cursor: 'default',
                userSelect: 'none',
            },
            '*': {
                userSelect: 'none',
            }
        }}
    />
)

export default GlobalStyles