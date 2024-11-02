from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .type_schema import TypeSchema
from .security import Security
from .operation import Operation
from .security_http_basic import SecurityHttpBasic
from .security_http_bearer import SecurityHttpBearer
from .security_api_key import SecurityApiKey
from .security_o_auth import SecurityOAuth


# The TypeAPI Root
class TypeAPI(TypeSchema):
    base_url: Optional[str] = Field(default=None, alias="baseUrl")
    security: Optional[Annotated[Union[Annotated[SecurityHttpBasic, Tag('httpBasic')], Annotated[SecurityHttpBearer, Tag('httpBearer')], Annotated[SecurityApiKey, Tag('apiKey')], Annotated[SecurityOAuth, Tag('oauth2')]], Field(discriminator='type')]
] = Field(default=None, alias="security")
    operations: Optional[Dict[str, Operation]] = Field(default=None, alias="operations")
    pass


