from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .map import Map
from .human_type import HumanType


class HumanMap(Map[HumanType, HumanType]):
    pass


