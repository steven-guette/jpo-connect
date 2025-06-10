import { Anchor } from '@mantine/core';
import { Link } from 'react-router-dom';

const LinkAnchor = ({ children, to, ...props }) => (
    <Anchor component={Link} to={to} {...props}>
        {children}
    </Anchor>
)

export default LinkAnchor