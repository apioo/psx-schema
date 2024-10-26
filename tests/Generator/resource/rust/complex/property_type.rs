use serde::{Serialize, Deserialize};
use integer_property_type::IntegerPropertyType;
use number_property_type::NumberPropertyType;
use string_property_type::StringPropertyType;
use boolean_property_type::BooleanPropertyType;
use map_property_type::MapPropertyType;
use array_property_type::ArrayPropertyType;
use any_property_type::AnyPropertyType;
use generic_property_type::GenericPropertyType;
use reference_property_type::ReferencePropertyType;

// Base property type
#[derive(Serialize, Deserialize)]
pub struct PropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

