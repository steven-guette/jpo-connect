import { Title, useMantineTheme } from '@mantine/core'

const PageTitle = ({ children, order = 1, style = {}, ...props }) => {
    const theme = useMantineTheme();
    return (
        <Title
            order={order}
            align="center"
            mb="xs"
            style={{
                fontSize: '2.4rem',
                fontWeight: 800,
                letterSpacing: '0.5px',
                color: theme.colors[theme.primaryColor][9],
                ...style
            }}
            {...props}
        >
            {children}
        </Title>
    )
}

export default PageTitle;